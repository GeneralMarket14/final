<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\ClassifiedProductDetailCollection;
use App\Http\Resources\V2\ClassifiedProductMiniCollection;
use Cache;
use App\Models\Shop;
use App\Models\Color;
use App\Models\Product;
use App\Models\Ad;
use App\Models\User;
use App\Models\FlashDeal;
use Illuminate\Http\Request;
use App\Utility\SearchUtility;
use App\Utility\CategoryUtility;
use App\Http\Resources\V2\ProductCollection;
use App\Http\Resources\V2\UserCollection;
use App\Http\Resources\V2\Seller\AdCollection;
use App\Http\Resources\V2\FlashDealCollection;
use App\Http\Resources\V2\ProductMiniCollection;
use App\Http\Resources\V2\Seller\ProductCollection as PCollection;
use App\Http\Resources\V2\ProductDetailCollection;
use App\Http\Resources\V2\DigitalProductDetailCollection;
use App\Models\Category;
use App\Models\CustomerProduct;

class ProductController extends Controller
{
    public function index()
    {
        return new ProductMiniCollection(Product::latest()->paginate(1000));
    }


    public function indexAd()
    {
        return new AdCollection(Ad::latest()->paginate(3));
    }

    public function show($id)
    {
        return new ProductDetailCollection(Product::where('id', $id)->get());
        // if (Product::findOrFail($id)->digital==0) {
        //     return new ProductDetailCollection(Product::where('id', $id)->get());
        // }elseif (Product::findOrFail($id)->digital==1) {
        //     return new DigitalProductDetailCollection(Product::where('id', $id)->get());
        // }
    }

    // public function admin()
    // {
    //     return new ProductCollection(Product::where('added_by', 'admin')->latest()->paginate(10));
    // }

    public function getPrice(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $str = '';
        $tax = 0;
        $quantity = 1;



        if ($request->has('quantity') && $request->quantity != null) {
            $quantity = $request->quantity;
        }

        if ($request->has('color') && $request->color != null) {
            $str = Color::where('code', '#' . $request->color)->first()->name;
        }

        $var_str = str_replace(',', '-', $request->variants);
        $var_str = str_replace(' ', '', $var_str);

        if ($var_str != "") {
            $temp_str = $str == "" ? $var_str : '-' . $var_str;
            $str .= $temp_str;
        }

        $product_stock = $product->stocks->where('variant', $str)->first();
        $price = $product_stock->price;


        if ($product->wholesale_product) {
            $wholesalePrice = $product_stock->wholesalePrices->where('min_qty', '<=', $quantity)->where('max_qty', '>=', $quantity)->first();
            if ($wholesalePrice) {
                $price = $wholesalePrice->price;
            }
        }

        $stock_qty = $product_stock->qty;
        $stock_txt = $product_stock->qty;
        $max_limit = $product_stock->qty;

        if ($stock_qty >= 1 && $product->min_qty <= $stock_qty) {
            $in_stock = 1;
        } else {
            $in_stock = 0;
        }

        //Product Stock Visibility
        if ($product->stock_visibility_state == 'text') {
            if ($stock_qty >= 1 && $product->min_qty < $stock_qty) {
                $stock_txt = translate('In Stock');
            } else {
                $stock_txt = translate('Out Of Stock');
            }
        }

        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        // taxes
        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }

        $price += $tax;

        return response()->json(

            [
                'result' => true,
                'data' => [
                    'price' => single_price($price * $quantity),
                    'stock' => $stock_qty,
                    'stock_txt' => $stock_txt,
                    'digital' => $product->digital,
                    'variant' => $str,
                    'variation' => $str,
                    'max_limit' => $max_limit,
                    'in_stock' => $in_stock,
                    'image' => $product_stock->image == null ? "" : uploaded_asset($product_stock->image)
                ]

            ]
        );
    }

    public function seller($id, Request $request)
    {
        $shop = Shop::findOrFail($id);
        $products = Product::where('added_by', 'seller')->where('user_id', $shop->user_id);
        if ($request->name != "" || $request->name != null) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        $products->where('published', 1);
        return new ProductMiniCollection($products->latest()->paginate(10));
    }
    
      public function manufacturer($id, Request $request)
    {
        $shop = Shop::findOrFail($id);
        $products = Product::where('added_by', 'manufacturer')->where('user_id', $id);
        // if ($request->name != "" || $request->name != null) {
        //     $products = $products->where('name', 'like', '%' . $request->name . '%');
        // }
        $products->where('published', 1);
        return new ProductMiniCollection($products->latest()->paginate(10));
    }
    
    
       public function retailer($id, Request $request)
    {
        // $shop = Shop::findOrFail($id);
        $products = Product::where('added_by', 'retailer')->where('user_id', $id);
        // if ($request->name != "" || $request->name != null) {
        //     $products = $products->where('name', 'like', '%' . $request->name . '%');
        // }
        $products->where('published', 1);
        return new ProductMiniCollection($products->latest()->get());
    }


    public function category($id, Request $request)
    {
        $category = Category::find($id);
        $products = $category->products()->physical();

        if ($request->name != "" || $request->name != null) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        
        return new ProductMiniCollection(filter_products($products)->latest()->paginate(10));
    }


    public function brand($id, Request $request)
    {
        $products = Product::where('brand_id', $id)->physical();
        if ($request->name != "" || $request->name != null) {
            $products = $products->where('name', 'like', '%' . $request->name . '%');
        }
        return new ProductMiniCollection(filter_products($products)->latest()->paginate(10));
    }

    public function todaysDeal()
    {
        // return Cache::remember('app.todays_deal', 86400, function () {
        $products = Product::where('todays_deal', 1)->physical();
        return new ProductMiniCollection(filter_products($products)->limit(20)->latest()->get());
        // });
    }

    public function flashDeal()
    {
        return Cache::remember('app.flash_deals', 86400, function () {
            $flash_deals = FlashDeal::where('status', 1)->where('featured', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->get();
            return new FlashDealCollection($flash_deals);
        });
    }

    public function featured()
    {
        $products = Product::where('featured', 1)->physical();
        return new ProductMiniCollection(filter_products($products)->latest()->paginate(10));
    }

    public function inhouse()
    {
        $products = Product::where('added_by', 'admin');
        return new ProductMiniCollection(filter_products($products)->latest()->paginate(12));
    }

    public function digital()
    {
        $products = Product::digital();
        return new ProductMiniCollection(filter_products($products)->latest()->paginate(10));
    }

    public function bestSeller()
    {
        // return Cache::remember('app.best_selling_products', 86400, function () {
        $products = Product::orderBy('num_of_sale', 'desc')->physical();
        return new ProductMiniCollection(filter_products($products)->limit(20)->get());
        // });
    }

    public function related($id)
    {
        // return Cache::remember("app.related_products-$id", 86400, function () use ($id) {
        $product = Product::find($id);
        $products = Product::where('category_id', $product->category_id)->where('id', '!=', $id)->physical();
        return new ProductMiniCollection(filter_products($products)->limit(10)->get());

        // });
    }

    public function topFromSeller($id)
    {
        // return Cache::remember("app.top_from_this_seller_products-$id", 86400, function () use ($id) {
        $product = Product::find($id);
        $products = Product::where('user_id', $product->user_id)->orderBy('num_of_sale', 'desc')->physical();
        return new ProductMiniCollection(filter_products($products)->limit(10)->get());
        // });
    }

public function search(Request $request)
{
    $name = $request->name;

    if (!empty($name)) {
        // Define the mapping of models and their searchable fields
        $modelMappings = [
            'product' => [
                'model' => Product::class,
                'fields' => ['category', 'name'],
                'collection' => PCollection::class,
            ],
            'user' => [
                'model' => User::class,
                'fields' => ['address', 'firstName', 'surName', 'email', 'mainoffice', 'areaofspecialization', 'state', 'city', 'lga'],
                'collection' => UserCollection::class,
            ],
            'ad' => [
                'model' => Ad::class,
                'fields' => ['caption', 'location'],
                'collection' => AdCollection::class,
            ],
        ];

        $results = [];

        // Iterate through each model mapping and search
        foreach ($modelMappings as $key => $mapping) {
            $model = $mapping['model'];
            $fields = $mapping['fields'];
            $collectionClass = $mapping['collection'];

            $queryResults = $model::query()
                ->where(function ($query) use ($fields, $name) {
                    foreach ($fields as $field) {
                        $query->orWhere($field, 'LIKE', "%{$name}%");
                    }
                })
                ->paginate(10);

            // Append the results in the results array with the key as identifier
            if ($queryResults->total() > 0) {
                $results[$key] = new $collectionClass($queryResults);
            }
        }

        // Check if any results found
        if (!empty($results)) {
            return response()->json($results);
        }
    }

    // Return an empty collection if name is empty or no matches found
    return response()->json([], 204);
}






    public function variantPrice(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $str = '';
        $tax = 0;

        if ($request->has('color') && $request->color != "") {
            $str = Color::where('code', '#' . $request->color)->first()->name;
        }

        $var_str = str_replace(',', '-', $request->variants);
        $var_str = str_replace(' ', '', $var_str);

        if ($var_str != "") {
            $temp_str = $str == "" ? $var_str : '-' . $var_str;
            $str .= $temp_str;
        }
        return   $this->calc($product, $str, $request, $tax);

        /*
        $product_stock = $product->stocks->where('variant', $str)->first();
        $price = $product_stock->price;
        $stockQuantity = $product_stock->qty;


        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;

        return response()->json([
            'product_id' => $product->id,
            'variant' => $str,
            'price' => (float)convert_price($price),
            'price_string' => format_price(convert_price($price)),
            'stock' => intval($stockQuantity),
            'image' => $product_stock->image == null ? "" : uploaded_asset($product_stock->image)
        ]);*/
    }

    // public function home()
    // {
    //     return new ProductCollection(Product::inRandomOrder()->physical()->take(50)->get());
    // }
}

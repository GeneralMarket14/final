<?php

namespace App\Http\Controllers\Api\V2\Seller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\V2\Seller\AttributeCollection;
use App\Http\Resources\V2\UserCollection;
use App\Http\Resources\V2\Seller\BrandCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\V2\Seller\CategoriesCollection;
use App\Http\Resources\V2\Seller\ColorCollection;
use App\Http\Resources\V2\Seller\ProductCollection;
use App\Http\Resources\V2\Seller\ProductpricehistoryCollection;
use App\Http\Resources\V2\Seller\AdCollection;
use App\Http\Resources\V2\Seller\ProductDetailsCollection;
use App\Http\Resources\V2\Seller\ProductReviewCollection;
use App\Http\Resources\V2\Seller\TaxCollection;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\User;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Productpricehistory;
use App\Models\Color;
use App\Models\Product;
use App\Models\Ad;
use App\Models\ProductTax;
use App\Models\ProductTranslation;
use App\Models\Review;
use App\Models\Tax;
use Artisan;
use DB;
use App\Models\Usernotification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Notifications\PriceChangedNotification;
class ProductController extends Controller
{
    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config_path('firebase.json'));
        $this->messaging = $factory->createMessaging();
    }
    
    public function notificationhistory(Request $request){
        $usernotification = Usernotification::where('user_id',$request->user_id);
        if($usernotification->exists()){
            $paginated = $usernotification->paginate(10);
           return response()->json([
            'result' => true,
            'message'=>'Success',
            'data' => $paginated
        ], 200);
        }else{
             return response()->json([
            'result' => false,
            'message'=> 'You do not have any notification'
            
        ], 200);
        }
        
        
    }
    
    public function retreive(Request $request){
        
        if(strtoupper($request->type) == 'PRODUCT'){
            $product = Product::where('id',$request->item_id);
            if($product->exists()){
                
                $productData = $product->first();
                $producte = Product::find($request->item_id);
     $user = User::find($producte->user_id);

    // Decode all JSON fields in the product data
    $productData = $producte->toArray();
    array_walk_recursive($productData, function (&$item, $key) {
        if (is_string($item) && is_array(json_decode($item, true))) {
            $item = json_decode($item);
        }
    });

    // Add the user model under the 'owner' key
    $productData['owner'] = $user;

if (isset($productData->images)) {
    $productData->images = json_decode($productData->images);
    $productData->currentPrice = json_decode($productData->currentPrice);
    $productData->oldPrice = json_decode($productData->oldPrice);
    $productData->dollarPrice = json_decode($productData->dollarPrice);
    $productData->predictedPrice = json_decode($productData->predictedPrice);
    $productData->newPredictedPrice = json_decode($productData->newPredictedPrice);
    $productData->thumbnail_img = json_decode($productData->thumbnail_img);
    
}
               return response()->json([
            'result' => true,
            'message' => 'Product Model',
            'data' => $productData
        ], 200);}else{
             return response()->json([
            'result' => false,
            'message'=> 'Product does not exist'
            
        ], 200);
        }
            
        }elseif(strtoupper($request->type) == 'AD'){
            $product = Ad::where('id',$request->item_id);
            if($product->exists){
               return response()->json([
            'result' => true,
            'message' => 'Ad Model',
            'data' => $product->first()
        ], 200);
            }else{
                 return response()->json([
            'result' => false,
            'message'=> 'Ad does not exist'
            
        ], 200);
            }
            
        }else{
            
            $product = User::where('id',$request->item_id);
            if($product->exists()){
               return response()->json([
            'result' => true,
            'message' => 'User Model',
            'data' => $product->first()
        ], 200);}else{
             return response()->json([
            'result' => false,
            'message'=> 'User not found'
            
        ], 200);
        }
            
        }
    }


    public function viewProduct(Request $request)
    {


        $product = Product::findOrFail($request->product_id);
        $user = $request->user_id;

        if ($user && !$product->viewers()->where('user_id', $user)->exists()) {
            $product->viewers()->attach($user);
        }
        $viewCount = $product->viewers()->count();

        return response()->json([
            'result' => true,
            'message' => 'View count increased',
            'views' => $viewCount
        ], 200);

    }



    public function viewAd(Request $request)
    {


        $product = Ad::findOrFail($request->ad_id);
        $user = $request->user_id;

        if ($user && !$product->viewers()->where('user_id', $user)->exists()) {
            $product->viewers()->attach($user);
        }
        $viewCount = $product->viewers()->count();

        return response()->json([
            'result' => true,
            'message' => 'View count increased',
            'views' => $viewCount
        ], 200);

    }


    public function index()
    {
        $products = Product::where('user_id', auth()->user()->id)->where('digital', 0)->where('auction_product', 0)->where('wholesale_product', 0)->orderBy('created_at', 'desc');
        $products = $products->paginate(50);
        return new ProductCollection($products);
    }

    public function byusers(Request $request)
    {
        $products = Product::where('user_id', $request->user_id)->where('digital', 0)->where('auction_product', 0)->where('wholesale_product', 0)->orderBy('created_at', 'desc');
        $products = $products->paginate(50);
        return new ProductCollection($products);
    }

    public function withuser(Request $request)
    {
        return new UserCollection(User::with('products')->paginate(10));
        return new ProductCollection($products);
    }

    public function adsIndex()
    {
        // $ads = Ad::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc');
        $ads = Ad::where('user_id', auth()->user()->id)->where('type', '!=', 'admin')->orderBy('created_at', 'desc');

        $ads = $ads->paginate(50);
        return new AdCollection($ads);
    }

    public function adminads()
    {
        $ads = Ad::where('type', 'admin')->orderBy('created_at', 'desc');
        $ads = $ads->paginate(50);
        return new AdCollection($ads);
    }

    public function likecheck($id)
    {
        $user = auth()->user();
        $product = Ad::findOrFail($id);
        if ($product->likedByUsers()->where('user_id', $user->id)->exists()) {
            return $this->success(translate('True'));

        } else {
            return $this->failed(translate('False'));

        }
    }




    public function unlikead($id)
    {
        $user = auth()->user();
        $product = Ad::findOrFail($id);

        if ($product->likedByUsers()->where('user_id', $user->id)->exists()) {



            // return response()->json([
            //     'message' => '',
            // ], 400);
            $product->likedByUsers()->detach($user->id);
            $product->likes -= 1;
            $product->save();


            // return $this->success(translate('Ads unliked successfully'));


            return response()->json([
                'result' => true,
                'message' => 'Ads unliked successfully',
                'likes' => $product->likes
            ], 200);
        }

        //   return $this->failed(translate('You have not liked this ad before'));

        // return response()->json([
        //     'message' => 'Product liked successfully',
        //     'product' => $product
        // ], 200);
    }





    public function likead($id)
    {
        $user = auth()->user();
        $product = Ad::findOrFail($id);

        if ($product->likedByUsers()->where('user_id', $user->id)->exists()) {

            return $this->failed(translate('You have already liked this Ad'));

            // return response()->json([
            //     'message' => '',
            // ], 400);
        }

        $product->likedByUsers()->attach($user->id);
        $product->likes += 1;
        $product->save();


        return response()->json([
            'result' => true,
            'message' => 'Ads liked successfully',
            'likes' => $product->likes
        ], 200);

        // return response()->json([
        //     'message' => 'Product liked successfully',
        //     'product' => $product
        // ], 200);
    }

    public function adsStore(Request $request)
    {
        if (auth()->user()->user_type != 'seller') {
            return $this->failed(translate('Unauthenticated User.'));
        }




        if ($request->caption == null && $request->media == null && $request->location == null) {
            return $this->failed(translate('Please add a caption or media  or Location'));
        }






        if ($request->hasFile('media')) {
            $uploadedFiles = $request->file('media');
            $uploadFolder = 'uploads/all';


            // Loop through each file and store it'


            $path = $uploadedFiles->store($uploadFolder);


            // Return a response or handle the rest of your logic
            $uploadedFiless = $request->file('media');


            $mimeType = $uploadedFiless->getMimeType();

            // Define arrays for image and video MIME types
            $imageMimeTypes = [
                'image/jpg',
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/bmp',
                'image/svg+xml',
                'image/webp',
            ];

            $videoMimeTypes = [
                'video/mp4',
                'video/x-msvideo',
                'video/x-ms-wmv',
                'video/quicktime',
                'video/x-flv',
                'video/x-matroska',
                'video/webm',
                'video/ogg',
                'video/mpeg',
            ];

            // Determine if the file is an image or video
            if (in_array($mimeType, $imageMimeTypes)) {
                $filetype = 'image';
            } elseif (in_array($mimeType, $videoMimeTypes)) {
                $filetype = 'video';
            } else {
                $filetype = null;
            }
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $folderolder = 'uploads/all';


            // Loop through each file and store it'


            $thumbpath = $file->store($folder);
        }

        $ad = Ad::create([
            'caption' => $request->caption,
            'location' => $request->location,
            'type' => auth()->user()->user_type,
            'audience' => $request->audience,
            'likes' => isset($request->likes) ? $request->likes : 0,
            'numberOfViews' => isset($request->numberOfViews) ? $request->numberOfViews : 0,
            'user_id' => auth()->user()->id,
            'media_type' => $filetype ?? null,
            'thumbnail' => isset($thumbpath) ? json_encode($thumbpath) : Null,
            'media' => isset($path) ? json_encode($path) : '' // Store the paths as a JSON array
        ]);

            $this->adnotifyFollowers($ad);

        return $this->success(translate('Ads has been inserted successfully'));

    }
    
    
    
    
    protected function adnotifyFollowers(Ad $product)
    {
        $user = User::findOrFail(auth()->user()->id);
        $followers = $user->followers()->get();
        foreach ($followers as $follower) {
               $message = strtoupper( uid(auth()->user()->id)->merchant_type) == 'EXPLORER' ?  uid(auth()->user()->id)->firstName.' '.uid(auth()->user()->id)->surName : uid(auth()->user()->id)->cacname.' '.'has uploaded a new Ad '.$product->caption ?? " ";
               if($follower->fcm_token){
$deviceTokens[] = $follower->fcm_token;
        Usernotification::create([
            'type' => 'Ad',
            'user_id' => $follower->id,
            'product_id' => $product->id,
            'product_name' => $product->caption,
            
            'message' => $message,
            
        ]);
            //  $follower->notify(new PriceChangedNotification($product));
        }
    }
            $this->adsendFirebaseNotification($deviceTokens, $product);


    }

    protected function adsendFirebaseNotification($deviceTokens, $product)
    {
        $factory = (new Factory)->withServiceAccount(config_path('firebase.json'));
        $messaging = $factory->createMessaging();
              $message = [
            'data' => [
                'body' => strtoupper( uid(auth()->user()->id)->merchant_type) == 'EXPLORER' ?  uid(auth()->user()->id)->firstName.' '.uid(auth()->user()->id)->surName : uid(auth()->user()->id)->cacname.' '.'has uploaded a new Ad '.$product->caption ?? " ",
                'type' => 'Ad',
                'id' => $product->id,
      
            ],
        ];
        // $message = [
        //     'notification' => [
        //         'title' => 'Price Change Notification',
        //         'body' => 'The price of ' . $product->name . ' has changed to $' . json_decode($product->currentPrice)->amount,
        //     ],
        // ];

        // Send multicast message
        $report = $messaging->sendMulticast($message, $deviceTokens);

        
        
        
        
        // $message = CloudMessage::withTarget('token', $token)
        //     ->withNotification(['title' => 'Price Change Notification', 'body' => 'The price of ' . $product->name . ' has changed to ' . json_decode($product->currentPrice)->amount]);

        // $this->messaging->send($message);
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    





    public function getCategory()
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return CategoriesCollection::collection($categories);
    }

    public function getBrands()
    {
        $brands = Brand::all();

        return BrandCollection::collection($brands);
    }
  
    public function getAttributes()
    {
        $attributes = Attribute::with('attribute_values')->get();

        return AttributeCollection::collection($attributes);
    }
    public function getColors()
    {
        $colors = Color::orderBy('name', 'asc')->get();

        return ColorCollection::collection($colors);
    }



    public function upload($images)
    {
        $file = $images;
        \Log::info('File Details:', [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        // Read the file contents
        $fileContents = file_get_contents($file->getRealPath());

        // Log a part of the file content (for example, first 100 bytes)
        \Log::info('File Contents (First 100 bytes):', [
            'content' => substr($fileContents, 0, 100)
        ]);

        // Move the file to the desired location
        $filePath = $file->store('uploads/all');

    }





    public function store(Request $request)
    {
        if (auth()->user()->user_type != 'seller') {
            return $this->failed(translate('Unauthenticated User.'));
        }


        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'available' => 'nullable',
            'oldPrice' => 'required',
            'currentPrice' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif' // Adjust rules as needed
        ]);

        // Handle image upload
        $imagePaths = [];

        $images = $request->file('images');

        // Check if the images variable is an array and count the number of files
        $imageCount = is_array($images) ? count($images) : 0;

        // Validate the request


        if ($imageCount > 3) {








            if ($request->hasFile('images')) {
                $uploadedFiles = $request->file('images');
                $uploadFolder = 'uploads/all';
                $paths = [];

                // Loop through each file and store it'

                foreach ($uploadedFiles as $file) {
                    $path = $file->store($uploadFolder);
                    $paths[] = $path;
                }

                // Return a response or handle the rest of your logic
            }


            $entries = DB::table('dollarrates')
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->get();

            $currentPriceData = json_decode($validatedData['currentPrice']);

            $currentPrice = $currentPriceData->amount;
            // Now you can use $amount for calculations


            $entry = $entries->count() > 1 ? $entries->last() : $entries->first();
            $predictedPrice = (0.001 * $currentPrice) + $currentPrice;

            $increasedDollar = ($entries->first()->rate * $predictedPrice) / $entries->last()->rate;
            // $increasedDollar = ($entries->first()->rate * $predictedPrice)/$entries->last()->rate;


            $product = Product::create([
                'name' => $validatedData['name'],
                'category' => $validatedData['category'],
                'description' => $validatedData['description'],
                'oldPrice' => $validatedData['oldPrice'],
                'currentPrice' => $validatedData['currentPrice'],
                'predictedPrice' => json_encode(['amount' => $predictedPrice, 'currency' => 'naira']),
                'dollarPrice' => json_encode(['amount' => $increasedDollar, 'currency' => 'naira']),
                'available' => $validatedData['available'],

                'user_id' => auth()->user()->id,
                'added_by' => auth()->user()->user_type,
                'images' => json_encode($paths) // Store the paths as a JSON array
            ]);

            $productpricehistory = Productpricehistory::create([
                'product_id' => $product->id,


                'currentPrice' => $validatedData['currentPrice'],
                'predictedPrice' => json_encode(['amount' => $predictedPrice, 'currency' => 'naira']),
                'dollarPrice' => json_encode(['amount' => $increasedDollar, 'currency' => 'naira']),
            ]);

            return $this->success(translate('Product has been inserted successfully'));
        } else {
            return $this->failed(translate('You have to upload more than three images'));

        }
    }






    public function pricehistory($id)
    {
        $price = Productpricehistory::where('product_id', $id)->get();
        if ($price != null) {
            return new ProductpricehistoryCollection($price);

        } else {
            return $this->failed(translate('Please check the id parsed'));

        }

    }



    public function edit(Request $request, $id)
    {

        if (auth()->user()->user_type != 'seller') {
            return $this->failed(translate('Unauthenticated User.'));
        }

        $product = Product::where('id', $id)->with('stocks')->first();

        if (auth()->user()->id != $product->user_id) {
            return $this->failed(translate('This product is not yours.'));
        }
        $product->lang = $request->lang == null ? env("DEFAULT_LANGUAGE") : $request->lang;

        return new ProductDetailsCollection($product);

    }




    public function update(Request $request, Product $product)
    {

        $oldPrices = json_decode($product->currentPrice)->amount;
// dd(json_decode($product->currentPrice)->amount);

        if ($product->user_id !== auth()->user()->id) {
            return $this->failed(translate('Unauthorized User.'));


        }

        $images = $request->file('images');

        // Check if the images variable is an array and count the number of files

        $imageCount = is_array($images) ? count($images) : 0;












        // Validate the request
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'oldPrice' => 'sometimes|required',
            'available' => 'nullable|boolean',
            'currentPrice' => 'sometimes|required',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048' // Adjust rules as needed
        ]);

        // Handle image upload
        $imagePaths = [];

        if ($imageCount >= 3) {


            $entries = DB::table('dollarrates')
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->get();

            $currentPriceData = json_decode($validatedData['currentPrice']);
            // dd( $validatedData['currentPrice']);
            $currentPrice = $currentPriceData->amount;
            // Now you can use $amount for calculations


            $entry = $entries->count() > 1 ? $entries->last() : $entries->first();
            $predictedPrice = (0.001 * $currentPrice) + $currentPrice;

            $increasedDollar = ($entries->first()->rate * $predictedPrice) / $entries->last()->rate;
            // $increasedDollar = ($entries->first()->rate * $predictedPrice)/$entries->last()->rate;

            // Output the number of images
// dd($imageCount);






            if ($request->hasFile('images')) {
                $uploadedFiles = $request->file('images');
                $uploadFolder = 'uploads/all';
                $paths = [];

                // Loop through each file and store it'

                foreach ($uploadedFiles as $file) {
                    $path = $file->store($uploadFolder);
                    $paths[] = $path;
                }

                // Return a response or handle the rest of your logic
            }



            $updateData = [
                'name' => $validatedData['name'] ?? $product->name,
                'category' => $validatedData['category'] ?? $product->category,
                'description' => $validatedData['description'] ?? $product->description,
                'oldPrice' => $validatedData['oldPrice'] ?? $product->oldPrice,
                'currentPrice' => $validatedData['currentPrice'] ?? $product->currentPrice,
                'available' => $validatedData['available'] ?? $product->available,
                'user_id' => auth()->user()->id,
                'predictedPrice' => json_encode(['amount' => $predictedPrice, 'currency' => 'naira']),
                'dollarPrice' => json_encode(['amount' => $increasedDollar, 'currency' => 'naira']),
                'added_by' => auth()->user()->user_type,
                'images' => json_encode($paths) ?? $product->images,
            ];

            // Update the product
            if ($product->update($updateData)) {
                $currentPrices = json_decode($product->currentPrice)->amount;
                if ($oldPrices != $currentPrices) {

                     $this->notifyFollowers($product);
                }
                $productpricehistory = Productpricehistory::create([
                    'product_id' => $product->id,
                    'currentPrice' => $validatedData['currentPrice'],
                    'predictedPrice' => json_encode(['amount' => $predictedPrice, 'currency' => 'naira']),
                    'dollarPrice' => json_encode(['amount' => $increasedDollar, 'currency' => 'naira']),
                ]);




                return $this->success(translate('Product has been updated successfully'));
            } else {
                return $this->failed(translate('An Error Occured'));

            }
        } else {
            return $this->failed(translate('Images has to be greater than 3'));

        }


    }






    protected function notifyFollowers(Product $product)
    {
        $user = User::findOrFail(auth()->user()->id);
        $followers = $user->followers()->get();
        foreach ($followers as $follower) {
               $message = 'The price of ' . $product->name . ' has changed to '.json_decode($product->currentPrice)->currency.''. json_decode($product->currentPrice)->amount;
               if($follower->fcm_token){
$deviceTokens[] = $follower->fcm_token;
        Usernotification::create([
            'type' => 'product',
            'user_id' => $follower->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'new_price' => $product->currentPrice,
            'message' => $message,
            
        ]);
            //  $follower->notify(new PriceChangedNotification($product));
        }
    }
            $this->sendFirebaseNotification($deviceTokens, $product);


    }

    protected function sendFirebaseNotification($deviceTokens, $product)
    {
        $factory = (new Factory)->withServiceAccount(config_path('firebase.json'));
        $messaging = $factory->createMessaging();
              $message = [
            'data' => [
                'body' => 'The price of ' . $product->name . ' has changed to '.json_decode($product->currentPrice)->currency.''.json_decode($product->currentPrice)->amount,
                'type' => 'product',
                'id' => $product->id,
      
            ],
        ];
        // $message = [
        //     'notification' => [
        //         'title' => 'Price Change Notification',
        //         'body' => 'The price of ' . $product->name . ' has changed to $' . json_decode($product->currentPrice)->amount,
        //     ],
        // ];

        // Send multicast message
        $report = $messaging->sendMulticast($message, $deviceTokens);

        
        
        
        
        // $message = CloudMessage::withTarget('token', $token)
        //     ->withNotification(['title' => 'Price Change Notification', 'body' => 'The price of ' . $product->name . ' has changed to ' . json_decode($product->currentPrice)->amount]);

        // $this->messaging->send($message);
    }






















    public function adsDelete(Request $request, Ad $ad)
    {
        if (auth()->user()->user_type != 'seller') {
            return $this->failed(translate('Unauthenticated User.'));
        }
        $delete = Ad::where('id', $ad)->delete();

        return $this->success(translate('Ads Deleted.'));
    }
    public function adsUpdate(Request $request, Ad $ad)
    {
        if (auth()->user()->user_type != 'seller') {
            return $this->failed(translate('Unauthenticated User.'));
        }



        // Validate the request
        $validatedData = $request->validate([
            'caption' => 'string|max:255',
            'location' => 'string|max:255',
            'audience' => 'string',
            'likes' => '',
            'numberOfViews' => '',
            'media.*' => '' // Adjust rules as needed
        ]);

        // Handle image upload



        // Output the number of images
// dd($imageCount);


        if ($request->hasFile('media')) {
            $uploadedFiles = $request->file('media');
            $uploadFolder = 'uploads/all';
            $paths = [];

            // Loop through each file and store it'

            foreach ($uploadedFiles as $file) {
                $path = $file->store($uploadFolder);
                $paths[] = $path;
            }

            // Return a response or handle the rest of your logic
        }



        $product = $ad->update([
            'caption' => $validatedData['caption'],
            'location' => $validatedData['location'],
            'audience' => $validatedData['audience'],
            'likes' => $validatedData['likes'],
            'numberOfViews' => $validatedData['numberOfViews'],
            'user_id' => auth()->user()->id,
            'media' => json_encode($paths) // Store the paths as a JSON array
        ]);



        return $this->success(translate('Ads has been updated successfully'));



    }








    public function change_status(Request $request)
    {
        if (addon_is_activated('seller_subscription')) {
            if (!seller_package_validity_check()) {
                return $this->failed(translate('Please upgrade your package'));
            }
        }

        $product = Product::where('user_id', auth()->user()->id)
            ->where('id', $request->id)
            ->update([
                'published' => $request->status
            ]);

        if ($product == 0) {
            return $this->failed(translate('This product is not yours'));
        }
        return ($request->status == 1) ?
            $this->success(translate('Product has been published successfully')) :
            $this->success(translate('Product has been unpublished successfully'));
    }

    public function change_featured_status(Request $request)
    {
        $product = Product::where('user_id', auth()->user()->id)
            ->where('id', $request->id)
            ->update([
                'seller_featured' => $request->featured_status
            ]);

        if ($product == 0) {
            return $this->failed(translate('This product is not yours'));
        }

        return ($request->featured_status == 1) ?
            $this->success(translate('Product has been featured successfully')) :
            $this->success(translate('Product has been unfeatured successfully'));
    }



    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if (auth()->user()->id != $product->user_id) {
                return response()->json([
                    'message' => translate('This product is not yours')
                ], 403);
            }

            $product->product_translations()->delete();
          

            if ($product->delete()) {
                Cart::where('product_id', $id)->delete();

                // Clear the cache
                Artisan::call('view:clear');
                Artisan::call('cache:clear');

                return response()->json([
                    'message' => translate('Product has been deleted successfully')
                ], 200);
            }

            return response()->json([
                'message' => translate('Failed to delete the product')
            ], 500);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => translate('Product not found')
            ], 404);
        }
    }

    public function product_reviews()
    {
        $reviews = Review::orderBy('id', 'desc')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->where('products.user_id', auth()->user()->id)
            ->select('reviews.id', 'reviews.rating', 'reviews.comment', 'reviews.status', 'reviews.updated_at', 'products.name as product_name', 'users.id as user_id', 'users.name', 'users.avatar')
            ->distinct()
            ->paginate(1);

        return new ProductReviewCollection($reviews);
    }

    public function remainingUploads()
    {
        $remaining_uploads = (max(0, auth()->user()->shop->product_upload_limit - auth()->user()->products->count()));
        return response()->json([
            'ramaining_product' => $remaining_uploads,
        ]);
    }


    public function getTimestamp()
    {
        // Get the current Unix timestamp in seconds
        $timestamp = now()->timestamp;

        // Construct the response array
        $response = [
            'timestamp' => $timestamp
        ];

        // Return the response as JSON
        return response()->json($response);
    }

    public function isfollowing($id)
    {
        $user = User::findOrFail($id);
        $follower = auth()->user();
        if (!$follower->isFollowing($user)) {
            $follower->followees()->attach($user->id);
            return $this->failed(translate('false'));

            // return response()->json(['message' => '']);
        } else {
            return $this->success(translate('true'));
        }
    }


    public function follow($id)
    {
        $user = User::findOrFail($id);
        $follower = auth()->user();

        if ($follower->id == $user->id) {
            return $this->failed(translate('You cannot follow yourself.'));

            // return response()->json(['message' => ''], 400);
        }

        if (!$follower->isFollowing($user)) {
            $follower->followees()->attach($user->id);
            return $this->success(translate('Successfully followed the user.'));

            // return response()->json(['message' => '']);
        }
        return $this->failed(translate('You are already following this user.'));
        // return response()->json(['message' => ''], 400);
    }

    public function unfollow($id)
    {
        $user = User::findOrFail($id);
        $follower = auth()->user();

        if ($follower->id == $user->id) {
            return $this->failed(translate('You cannot unfollow yourself.'));
            // return response()->json(['message' => ''], 400);
        }

        if ($follower->isFollowing($user)) {
            $follower->followees()->detach($user->id);
            return $this->success(translate('Successfully unfollowed the user.'));
            // return response()->json(['message' => '']);
        }

        return $this->failed(translate('You are not following this User'));
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->get();
        // return new UserCollection(User::with('products')->paginate(10));
        // return response()->json($followers);
        return new UserCollection($followers);
    }

    public function followees($id)
    {
        $user = User::findOrFail($id);
        $followees = $user->followees()->get();
        return new UserCollection($followees);
        // return response()->json($followees);
    }

    public function audiencetype(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user->audience_type = $request->audience_type;
        if ($user->update()) {
            return response()->json($user);
        } else {
            return $this->failed(translate('An Error occured'));

        }

    }


}

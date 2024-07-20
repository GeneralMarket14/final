<?php

namespace App\Http\Controllers\Api\V2;


use App\Models\Search;
use App\Models\Product;
use App\Models\User;
use App\Models\Ad;
use App\Models\Brand;
use App\Models\Shop;
use Illuminate\Http\Request;

class SearchSuggestionController extends Controller
{
    public function getList(Request $request)
    {
      $query_key = $request->query_key;

// Initialize the array to hold the search results
$items = [];

// Function to search through a table based on columns
function searchTable($model, $columns, $query_key, $type, $type_string) {
    $query = $model::query();
    if ($query_key != "") {
        $query->where(function ($query) use ($columns, $query_key) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', "%{$query_key}%");
            }
        });
    }
    $results = $query->limit(3)->get();
    $items = [];
    if (!empty($results)) {
        foreach ($results as $result) {
            $item = [];
            $item['id'] = $result->id;
            $item['query'] = $result->{$columns[0]};
            $item['count'] = 0;
            $item['type'] = $type;
            $item['type_string'] = $type_string;
            $items[] = $item;
        }
    }
    return $items;
}

// Search through the 'searches' table


// Search through the 'users' table
$userItems = searchTable(User::class, ['firstName', 'email','address','mainoffice','surName','areaofspecialization','city','state','lga'], $query_key, 'user', 'User');
$items = array_merge($items, $userItems);

// Search through the 'products' table
$productItems = searchTable(Product::class, ['name', 'description'], $query_key, 'product', 'Product');
$items = array_merge($items, $productItems);

// Search through the 'ads' table
$adItems = searchTable(Ad::class, ['caption', 'location'], $query_key, 'ad', 'Ad');
$items = array_merge($items, $adItems);

// Enclose the results within an object
$object = (object) ['data' => $items];

// To return as JSON
return json_encode($object, JSON_PRETTY_PRINT);


       // return json_decode(json_encode($items)); // should return a valid json of search list;
    }
}

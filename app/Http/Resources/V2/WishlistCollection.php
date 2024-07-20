<?php

namespace App\Http\Resources\V2;
use App\Models\User;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WishlistCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'product' => [
                        'id' => $data->product->id,
                  
                          'name' => $data->product->name,
                    'description' => $data->product->description,
                    'category' => $data->product->category,
                    'images' =>json_decode($data->product->images),
                    'oldPrice' => json_decode($data->product->oldPrice),
                    'currentPrice' => json_decode($data->product->currentPrice),
                 
                    'status' => $data->product->published == 0 ? false : true,
                   
                    'featured' => $data->product->seller_featured == 0 ? false : true,
                    'owner' => User::where('id', $data->product->user_id)->first()
                    ]
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}

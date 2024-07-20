<?php

namespace App\Http\Resources\V2\Seller;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\User;
class ProductpricehistoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function ($data) {
              
             
                return [
                  
                    'price' => json_decode($data->currentPrice),
                      'predictedPrice' => json_decode($data->predictedPrice),
                    'dollarPrice' => json_decode($data->dollarPrice),
                 
                    'date' => $data->created_at,
                
                ];
            }),

        ];
    }
}

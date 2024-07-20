<?php

namespace App\Http\Resources\V2\Seller;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\User;
class ProductCollection extends ResourceCollection
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
                $qty = 0;
                foreach ($data->stocks as $key => $stock) {
                    $qty += $stock->qty;
                }
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'description' => $data->description,
                    'category' => $data->category,
                    'images' =>json_decode($data->images),
                    'oldPrice' => json_decode($data->oldPrice),
                    'currentPrice' => json_decode($data->currentPrice),
                    'predictedPrice' => json_decode($data->predictedPrice),
                    'dollarPrice' => json_decode($data->dollarPrice),
                    'status' => $data->published == 0 ? false : true,
                   'avalaible'=> $data->available,
                   'views'=>$data->viewers()->count(),
                    'featured' => $data->seller_featured == 0 ? false : true,
                    'owner' => User::where('id',$data->user_id)->first()
                ];
            }),

        ];
    }
}

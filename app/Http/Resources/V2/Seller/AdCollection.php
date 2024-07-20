<?php

namespace App\Http\Resources\V2\Seller;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\User;
class AdCollection extends ResourceCollection
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
                    'id' => $data->id,
                    'caption' => $data->caption,
                    'location' => $data->location,
                    'audience' => $data->audience,
                    'media' =>json_decode($data->media),
                    'numberOfView' => $data->numberOfView,
                    'likes' => $data->likes,
                    'thumbnail' => $data->thumbnail,
                    'media_type' => $data->media_type,
                 
                  
                    'owner' => User::where('id',$data->user_id)->first()
                ];
            }),

        ];
    }
}

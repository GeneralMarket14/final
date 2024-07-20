<?php

namespace App\Http\Resources\V2\Seller;

use App\Http\Resources\V2\UploadedFileCollection;
use App\Models\Upload;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsCollection extends JsonResource
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
            "id" => $this->id,
          
            'name'  => $this->getTranslation('name', $this->lang),
            
            'description'   => $this->getTranslation('description', $this->lang),
            "category" => $this->category,
           
            "images" => $this->images,
            // "thumbnail_img" => new UploadedFileCollection(Upload::whereIn("id", explode(",", $this->thumbnail_img))->get()),
          
            "oldPrice" =>  json_decode($this->oldPrice),
            "currentPrice" => json_decode($this->currentPrice),
            
            "predictedPrice" => $this->predictedPrice,
            "dollarPrice" => $this->dollarPrice,
            
            
            "num_of_sale" => $this->num_of_sale,
          

           
            // "created_at" => $this->created_at,
            // "updated_at" => $this->updated_at,
        ];
    }


    public function with($request)
    {
        return [
            'result' => true,
            'status' => 200
        ];
    }
}

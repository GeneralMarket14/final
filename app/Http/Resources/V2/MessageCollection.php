<?php

namespace App\Http\Resources\V2;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'user_id' => intval($data->user_id),
                    'sender_id' => intval($data->user_id),
                    'reciever_id' => intval($data->reciever_id),
                    'conversation_id' => intval($data->conversation_id),
                    'temp_id' => intval($data->temp_id),
                    'send_type' => $data->user->merchant_type,
                    'message' => $data->message,
                    'year' => Carbon::createFromFormat('Y-m-d H:i:s',$data->created_at)->format('Y'),
                    'month' => Carbon::createFromFormat('Y-m-d H:i:s',$data->created_at)->format('m'),
                    'day_of_month' => Carbon::createFromFormat('Y-m-d H:i:s',$data->created_at)->format('d-M'),
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s',$data->created_at)->format('F d, Y'),
                    'time' => Carbon::createFromFormat('Y-m-d H:i:s',$data->created_at)->format('h:i a'),
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'result' => true,
            'success' => true,
            'status' => 200
        ];
    }
}

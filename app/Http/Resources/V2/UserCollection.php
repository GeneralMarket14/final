<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($dataObject) {
                return [
                  
    'id' => $dataObject->id,
    'referred_by' => $dataObject->referred_by,
    'provider' => $dataObject->provider,
    'provider_id' => $dataObject->provider_id,
    'refresh_token' => $dataObject->refresh_token,
    'access_token' => $dataObject->access_token,
    'user_type' => $dataObject->user_type,
    'merchant_type' => $dataObject->merchant_type,
    'audience_type' => $dataObject->audience_type,
    'name' => $dataObject->name,
    'number' => $dataObject->number,
    'email' => $dataObject->email,
    'email_verified_at' => $dataObject->email_verified_at,
    'verification_code' => $dataObject->verification_code,
    'new_email_verificiation_code' => $dataObject->new_email_verificiation_code,
    'device_token' => $dataObject->device_token,
    'avatar' => $dataObject->avatar,
    'avatar_original' => $dataObject->avatar_original,
    'address' => $dataObject->address,
    'cacname' => $dataObject->cacname,
    'cacnumber' => $dataObject->cacnumber,
    'country' => $dataObject->country,
    'state' => $dataObject->state,
    'lga' => $dataObject->lga,
    'city' => $dataObject->city,
    'firstName' => $dataObject->firstName,
    'mainoffice' => $dataObject->mainoffice,
    'surName' => $dataObject->surName,
    'areaofspecialization' => $dataObject->areaofspecialization,
    'tinnumber' => $dataObject->tinnumber,
    'postal_code' => $dataObject->postal_code,
    'phone' => $dataObject->phone,
    'balance' => $dataObject->balance,
    'banned' => $dataObject->banned,
    'referral_code' => $dataObject->referral_code,
    'customer_package_id' => $dataObject->customer_package_id,
    'remaining_uploads' => $dataObject->remaining_uploads,
    'created_at' => $dataObject->created_at,
    'updated_at' => $dataObject->updated_at,


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

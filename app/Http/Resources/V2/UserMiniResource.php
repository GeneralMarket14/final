<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMiniResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'referred_by' => $this->referred_by,
            'provider' => $this->provider,
            'provider_id' => $this->provider_id,
            'refresh_token' => $this->refresh_token,
            'access_token' => $this->access_token,
            'user_type' => $this->user_type,
            'merchant_type' => $this->merchant_type,
            'audience_type' => $this->audience_type,
            'name' => $this->name,
            'number' => $this->number,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'verification_code' => $this->verification_code,
            'new_email_verificiation_code' => $this->new_email_verificiation_code,
            'device_token' => $this->device_token,
            'avatar' => $this->avatar,
            'avatar_original' => $this->avatar_original,
            'address' => $this->address,
            'cacname' => $this->cacname,
            'cacnumber' => $this->cacnumber,
            'country' => $this->country,
            'state' => $this->state,
            'lga' => $this->lga,
            'city' => $this->city,
            'firstName' => $this->firstName,
            'mainoffice' => $this->mainoffice,
            'surName' => $this->surName,
            'areaofspecialization' => $this->areaofspecialization,
            'tinnumber' => $this->tinnumber,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'balance' => $this->balance,
            'banned' => $this->banned,
            'referral_code' => $this->referral_code,
            'customer_package_id' => $this->customer_package_id,
            'remaining_uploads' => $this->remaining_uploads,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'result' => true,
            'success' => true,
            'status' => 200,
            'message' => 'Updated Successfully'
        ];
    }
}

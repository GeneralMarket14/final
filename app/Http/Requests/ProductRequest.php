<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $rules['name']          = 'required|max:255';
        $rules['category']  = 'required';
       
        
        $rules['description']      = 'sometimes|required|string';
        $rules['oldPrice.amount'] = 'sometimes|required|numeric';
        $rules['oldPrice.currency'] = 'sometimes|required|string';
        $rules['currentPrice.amount'] = 'sometimes|required|numeric';
        $rules['currentPrice.currency'] = 'sometimes|required|string';
            

        return $rules;
    }

    /**
     * Get the validation messages of rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'             => translate('Product name is required'),
            'category.required'     => translate('Product category is required'),
   
         
            'description.required'          => translate('Description is required'),

           'oldPrice.amount.required' => translate('Old price amount is required'),
        'oldPrice.amount.numeric' => translate('Old price amount must be numeric'),
        'oldPrice.currency.required' => translate('Old price currency is required'),
        'oldPrice.currency.string' => translate('Old price currency must be a string'),
        'currentPrice.amount.required' => translate('Current price amount is required'),
        'currentPrice.amount.numeric' => translate('Current price amount must be numeric'),
        'currentPrice.currency.required' => translate('Current price currency is required'),
        'currentPrice.currency.string' => translate('Current price currency must be a string'),
           
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    public function failedValidation(Validator $validator)
    {
        // dd($this->expectsJson());
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'message' => $validator->errors()->all(),
                'result' => false
            ], 422));
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'business_account_id' => ['required', 'exists:business_accounts,id'],

          'category_id' => 'required|exists:categories,id',
          'sub_category_id' => 'nullable|exists:sub_categories,id',

        'title_ar' => 'required',
        'title_en' => 'required',

        'description.ar' => 'required',
        'description.en' => 'required',

        'quantity' => 'required|numeric',
        'service_type' => 'required',

//
'price_usd' => 'required|numeric|min:0',
'price_syp' => 'required|numeric|min:0',
//
        'latitude' => 'required',
        'longitude' => 'required',

        'value'  => ['nullable' ],
        'main_image' => 'required|image',
        'images' => 'required',
        ];
    }
}
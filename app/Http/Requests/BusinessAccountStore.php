<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BusinessAccountStore extends FormRequest
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
          'activity_id' => [ 'required','exists:activity_types,id',
            Rule::unique('business_accounts', 'activity_type_id')
            ->where('normal_user_id', auth()->user()->normalUser->id),  ] ,
          'city_id' => 'required|exists:cities,id',
          'license_number' => 'required|string|max:255',

          'business_name_ar' => 'required|string|max:255',
          'business_name_en' => 'required|string|max:255',

          'description' => 'nullable|array',
          'description.ar' => 'nullable|string',
          'description.en' => 'nullable|string',

          'latitude' => 'required|numeric',
          'longitude' => 'required|numeric',
          'logo' => ['nullable', 'file', 'image'],
'attachments.*' => ['nullable', 'file'],

        ];
    }
}

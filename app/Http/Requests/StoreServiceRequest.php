<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
          // علاقات
          'business_account_id' => ['required', 'exists:business_accounts,id'],
          'category_id' => ['required', 'exists:categories,id'],
          'sub_category_id' => ['nullable', 'exists:sub_categories,id'],

          // العناوين
          'title_ar' => ['required', 'string', 'max:255'],
          'title_en' => ['required', 'string', 'max:255'],

          // الوصف (json)
          'description' => ['nullable', 'array'],
          'description.ar' => ['nullable', 'string'],
          'description.en' => ['nullable', 'string'],

          // تفاصيل
          'quantity' => ['required', 'integer', 'min:1'],

          'service_type' => ['required', 'in:sale,rent'],
//

//
'price_usd' => 'required|numeric|min:0',
'price_syp' => 'required|numeric|min:0',
          // الموقع
          'latitude' => ['nullable', 'numeric', 'between:-90,90'],
          'longitude' => ['nullable', 'numeric', 'between:-180,180'],

          // الحالة (اختياري لأن عندها default)
          'status' => ['nullable', 'in:pending,accepted,rejected'],
          'value'  => ['nullable' ],

      ];

    }
}
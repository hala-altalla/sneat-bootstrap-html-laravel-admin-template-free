<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDynamicFieldsRequest extends FormRequest
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
          'category_id' => 'required',
          'category_id.*' => 'exists:categories,id',
          'subcategory_id'=>'nullable|exists:sub_categories,id',


          'name.ar' => 'required|string',
          'name.en' => 'required|string',

          'type' => 'required|in:text,number,select',
          'is_required' => 'nullable|boolean',

          'options' => 'required_if:type,select|array',
          'options.*.ar' => 'required_if:type,select|string',
          'options.*.en' => 'required_if:type,select|string',
        ];
    }
}
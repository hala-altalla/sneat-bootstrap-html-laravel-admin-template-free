<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreorderRequest extends FormRequest
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
          'business_account_id'  => 'required|exists:business_accounts,id',
          'service_id' => 'required|exists:services,id',
        //  'needed_at' => 'required|date',
        'needed_at' => 'required|date|after_or_equal:' . now()->addDays(3)->toDateString(),
          'quantity' => 'required|integer|min:1',
          'details' => 'required|string',
        ];
    }
}
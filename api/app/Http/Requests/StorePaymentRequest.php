<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|size:3',
            'description' => 'nullable|string|max:255',
            'idempotency_key' => 'required|string|max:100',
            'provider' => 'required|string|in:yookassa',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all customers to checkout
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customerName' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/', // Only letters and spaces
            ],
            'customerPhone' => [
                'required',
                'string',
                'regex:/^(08|62)[0-9]{9,12}$/', // Indonesian phone format
            ],
            'tableNumber' => 'required|string|max:20',
            'paymentMethod' => 'required|in:cash,qris,transfer',
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'customerName.required' => 'Nama pelanggan harus diisi.',
            'customerName.min' => 'Nama pelanggan minimal 3 karakter.',
            'customerName.max' => 'Nama pelanggan maksimal 50 karakter.',
            'customerName.regex' => 'Nama pelanggan hanya boleh berisi huruf dan spasi.',

            'customerPhone.required' => 'Nomor telepon harus diisi.',
            'customerPhone.regex' => 'Format nomor telepon tidak valid. Gunakan format 08xxx atau 62xxx.',

            'tableNumber.required' => 'Nomor meja harus diisi.',

            'paymentMethod.required' => 'Metode pembayaran harus dipilih.',
            'paymentMethod.in' => 'Metode pembayaran tidak valid.',
        ];
    }
}

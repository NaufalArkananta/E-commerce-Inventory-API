<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'ID produk harus diisi.',
            'product_id.exists' => 'Produk tidak ditemukan.',
            'quantity.required' => 'Kuantitas harus diisi.',
            'quantity.integer' => 'Kuantitas harus berupa angka.',
        ];
    }
}

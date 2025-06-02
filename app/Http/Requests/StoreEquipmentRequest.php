<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // kalau perlu, tambahkan logic authorization di sini
    }

    public function rules(): array
    {
        return [
            'nama_item' => 'required|string|max:255',
            'manufaktur' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'kondisi_barang' => 'required|string',
            'umur' => 'required|integer|min:1',
            'created_at' => 'nullable|date',
        ];
    }
}

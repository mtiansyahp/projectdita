<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // kalau perlu, tambahkan logic authorization di sini
    }

    public function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|string|in:admin,pegawai,atasan',
            'is_active' => 'required|boolean',
        ];
    }
}

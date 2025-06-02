<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'     => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|email|unique:users,email,' . $this->user->id,
            'role'     => 'sometimes|required|string|in:admin,pegawai,atasan',
            'is_active' => 'sometimes|required|boolean',
        ];
    }
}

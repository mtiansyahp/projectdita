<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApprovalPelaporanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'manufaktur' => 'required|string',
            'namaBarang' => 'required|string',
            'riwayat' => 'required|string',
            'kelayakan' => 'required|integer',
            'catatan' => 'nullable|string',
            'evidence' => 'required|array|min:1',
            'evidence.*.name' => 'required|string',
            'evidence.*.url' => 'nullable|string', // <= ini boleh kosong
            'evidence.*.user_maker' => 'required|string',
            'evidence.*.status_approve' => 'required|string',
            'evidence.*.approval_sequence' => 'required|integer',
        ];
    }
}

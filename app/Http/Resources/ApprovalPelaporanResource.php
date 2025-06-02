<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalPelaporanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'manufaktur' => $this->manufaktur,
            'namaBarang' => $this->namaBarang,
            'riwayat' => $this->riwayat,
            'kelayakan' => $this->kelayakan,
            'catatan' => $this->catatan,
            'created_at' => $this->created_at,
            'evidence' => EvidenceResource::collection($this->evidences),
        ];
    }
}

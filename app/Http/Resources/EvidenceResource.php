<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EvidenceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'evidence_id' => $this->evidence_id,
            'name' => $this->name,
            'url' => $this->url,
            'user_maker' => $this->user_maker,
            'created_at' => $this->created_at,
            'tanggal_approve' => $this->tanggal_approve,
            'status_approve' => $this->status_approve,
            'approval_sequence' => $this->approval_sequence,
        ];
    }
}

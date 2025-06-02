<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentLaboratoriumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'unique_id'      => $this->unique_id,
            'nama_item'      => $this->nama_item,
            'manufaktur'     => $this->manufaktur,
            'quantity'       => $this->quantity,
            'umur'           => $this->umur,
            'kondisi_barang' => $this->kondisi_barang,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}

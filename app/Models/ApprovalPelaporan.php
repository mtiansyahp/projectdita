<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApprovalPelaporan extends Model
{
    protected $table = 'approval_pelaporan';

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = true; // pastikan ini aktif

    protected $fillable = [
        'id',
        'manufaktur',
        'namaBarang',
        'riwayat',
        'kelayakan',
        'catatan',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid(); // tidak wajib jika set dari controller
            }
        });
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class, 'approval_id', 'id');
    }
}

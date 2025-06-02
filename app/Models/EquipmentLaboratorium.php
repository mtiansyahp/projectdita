<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EquipmentLaboratorium extends Model
{
    // Nama tabel jika tidak memakai plural otomatis
    protected $table = 'equipment_laboratorium';

    // Primary key bukan 'id'
    protected $primaryKey = 'unique_id';

    // UUID kita pakai string, bukan auto-increment
    public $incrementing = false;
    protected $keyType = 'string';

    // Aktifkan timestamps (created_at, updated_at)
    public $timestamps = true;

    // Kolom–kolom yang boleh di-mass assign
    protected $fillable = [
        'nama_item',
        'manufaktur',
        'quantity',
        'kondisi_barang',
        'umur',
        'created_at', // tambahkan ini
    ];


    /**
     * Generate UUID tanpa strip (32-char hex) secara otomatis
     * ketika model baru dibuat.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->unique_id)) {
                // Buang '-' agar 32 karakter
                $model->unique_id = str_replace('-', '', (string) Str::uuid());
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'unique_id';
    }
}

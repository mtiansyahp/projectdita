<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Evidence extends Model
{
    protected $table = 'evidence';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',              // primary key UUID
        'approval_id',     // foreign key
        'name',
        'url',
        'user_maker',
        'created_at',
        'tanggal_approve',
        'status_approve',
        'approval_sequence',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // Jangan generate ID di sini jika ingin id = approval_id
            if (!$model->created_at) {
                $model->created_at = now();
            }
        });
    }

    public function approval()
    {
        return $this->belongsTo(ApprovalPelaporan::class, 'approval_id', 'id');
    }
}

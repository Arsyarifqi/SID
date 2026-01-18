<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RtUnit extends Model
{
    protected $guarded = [];

    /**
     * Relasi ke RW: Satu RT dimiliki oleh satu RW
     */
    public function rwUnit()
    {
        return $this->belongsTo(RwUnit::class, 'rw_unit_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RwUnit extends Model
{
    protected $guarded = [];

    /**
     * Relasi: Satu RW memiliki banyak RT
     */
    public function rtUnits()
    {
        return $this->hasMany(RtUnit::class, 'rw_unit_id');
    }
}
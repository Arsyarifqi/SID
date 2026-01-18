<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $table = 'residents';
    protected $guarded = [];

    /**
     * Relasi ke Model User (Pencocokan NIK)
     * Menghubungkan NIK di tabel 'residents' dengan NIK di tabel 'users'.
     */
    public function user()
    {
        // Kita hubungkan berdasarkan kolom 'nik' agar sinkron
        return $this->hasOne(User::class, 'nik', 'nik');
    }

    /**
     * Relasi ke Model Complain (Eps 11)
     */
    public function complains()
    {
        return $this->hasMany(Complain::class, 'resident_id');
    }

    public function rwUnit()
    {
        return $this->belongsTo(RwUnit::class, 'rw_unit_id');
    }

    public function rtUnit()
    {
        return $this->belongsTo(RtUnit::class, 'rt_unit_id');
    }
}
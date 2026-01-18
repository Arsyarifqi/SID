<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $fillable = [
        'resident_id',
        'type',
        'necessity',
        'status',
        'admin_note'
    ];

    /**
     * Relasi ke Penduduk
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
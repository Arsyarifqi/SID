<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Complain extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke Model Resident (Ep 13: Penting untuk Admin melihat nama pelapor)
     */
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Accessor untuk Format Tanggal
     */
    public function getReportedDateLabelAttribute()
    {
        return Carbon::parse($this->reported_date)->translatedFormat('d F Y');
    }

    /**
     * Accessor untuk Label Status (Bahasa Indonesia)
     */
    public function getStatusLabelAttribute()
    {
        if ($this->status == 'new') return 'Baru';
        if ($this->status == 'processing') return 'Diproses';
        return 'Selesai';
    }

    /**
     * Accessor untuk Warna Status (Ep 13: Pembeda warna otomatis)
     * Digunakan di: class="badge badge-{{ $item->status_color }}"
     */
    public function getStatusColorAttribute()
    {
        if ($this->status == 'new') return 'info';       // Biru
        if ($this->status == 'processing') return 'warning'; // Kuning
        if ($this->status == 'done') return 'success';   // Hijau
        return 'secondary'; // Abu-abu jika tidak ada status
    }
}
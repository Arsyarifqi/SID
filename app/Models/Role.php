<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Mengizinkan pengisian data otomatis
    protected $guarded = [];

    /**
     * Konstanta ID Role (Ep 13)
     * Memudahkan pengecekan role di seluruh aplikasi
     */
    public const ADMIN = 1;
    public const USER  = 2;
}
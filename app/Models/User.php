<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'nik',      // Wajib ada untuk proses registrasi & verifikasi
        'name',
        'email',
        'password',
        'role_id', 
        'status',   // submitted, approved, rejected
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke model Role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relasi ke Model Resident (Pencocokan NIK)
     * Menghubungkan NIK di tabel 'users' dengan NIK di tabel 'residents'.
     */
    public function resident()
    {
        /**
         * hasOne(NamaModel, foreign_key_di_tabel_penduduk, local_key_di_tabel_user)
         * Dengan ini, Admin bisa cek: $user->resident->nama_lengkap 
         * Jika hasilnya NULL, berarti NIK ini bukan penduduk desa tersebut.
         */
        return $this->hasOne(Resident::class, 'nik', 'nik');
    }

    /**
     * Helper untuk cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return (int) $this->role_id === 1;
    }

    /**
     * Helper untuk cek apakah akun sudah disetujui
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Helper Baru: Cek validitas penduduk saat verifikasi Admin
     */
    public function isValidResident()
    {
        // Jika relasi resident mengembalikan data, berarti NIK cocok
        return $this->resident()->exists();
    }
}
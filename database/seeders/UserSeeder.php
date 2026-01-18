<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Resident;
use App\Models\RwUnit; // Tambahkan ini
use App\Models\RtUnit; // Tambahkan ini
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Ambil data Wilayah dari database (hasil WilayahSeeder)
        // Kita ambil RW dan RT pertama sebagai contoh
        $rw = RwUnit::first();
        $rt = RtUnit::where('rw_unit_id', $rw->id)->first();

        // 1. Membuat akun Admin
        User::create([
            'id' => 1,
            'name' => 'Admin Si Desa',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'status' => 'approved',
            'role_id' => 1,
        ]);

        // 2. Membuat akun Penduduk (User)
        $user = User::create([
            'id' => 2,
            'name' => 'Adam Penduduk',
            'email' => 'penduduk@gmail.com',
            'password' => Hash::make('password'),
            'status' => 'approved',
            'role_id' => 2,
        ]);

        // 3. Membuat Data Penduduk yang terhubung ke akun & wilayah
        Resident::create([
            'user_id' => $user->id,
            'nik' => '1234567890123456',
            'name' => 'Adam Penduduk',
            'gender' => 'male',
            'birth_place' => 'Cirebon',
            'birth_date' => '2000-01-01',
            'address' => 'Jl. Desa Merdeka No. 10',
            'marital_status' => 'single',
            'status' => 'active', // Tambahkan status agar lengkap
            'rw_unit_id' => $rw->id, // WAJIB ADA
            'rt_unit_id' => $rt->id, // WAJIB ADA
        ]);
    }
}
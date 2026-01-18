<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // URUTAN SANGAT PENTING!
        $this->call([
            RoleSeeder::class,     // 1. Role (Admin/User)
            WilayahSeeder::class,  // 2. WILAYAH (RW & RT) -> Harus sebelum User/Resident
            UserSeeder::class,     // 3. User & Resident
            ComplainSeeder::class, // 4. Pengaduan
        ]);
    }
}
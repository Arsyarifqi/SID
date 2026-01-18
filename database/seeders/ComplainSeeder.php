<?php

namespace Database\Seeders;

use App\Models\Complain;
use App\Models\Resident;
use Illuminate\Database\Seeder;

class ComplainSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil data resident pertama (Adam) yang dibuat di UserSeeder
        $resident = Resident::first();

        if ($resident) {
            // 2. Buat data aduan contoh
            Complain::create([
                'resident_id' => $resident->id,
                'title'       => 'Lampu Jalan Mati',
                'content'     => 'Lampu jalan di depan blok C10 mati sudah 3 hari, mohon segera diperbaiki karena gelap saat malam.',
                'status'      => 'new',
                'reported_date' => now(),
            ]);

            Complain::create([
                'resident_id' => $resident->id,
                'title'       => 'Sampah Menumpuk',
                'content'     => 'Petugas kebersihan belum mengangkut sampah di area gang mawar sejak senin lalu.',
                'status'      => 'processing',
                'reported_date' => now()->subDays(2), // 2 hari yang lalu
            ]);
        }
    }
}
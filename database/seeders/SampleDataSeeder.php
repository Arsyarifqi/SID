<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;
use App\Models\Complain;
use App\Models\RwUnit;
use App\Models\RtUnit;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $rwUnits = RwUnit::all();
        $rtUnits = RtUnit::all();

        if ($rwUnits->isEmpty()) {
            $this->command->error('Data RW masih kosong!');
            return;
        }

        for ($i = 1; $i <= 20; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $name = $faker->name($gender);
            
            // 1. Buat User
            $user = User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '', $name)) . $i . "@example.com",
                'password' => Hash::make('password'),
                'role_id' => 2, // Role Warga
            ]);

            // 2. Buat Resident
            $resident = Resident::create([
                'user_id' => $user->id,
                'nik' => $faker->unique()->numerify('################'),
                'name' => $name,
                'gender' => $gender,
                'birth_place' => $faker->city,
                'birth_date' => $faker->date('Y-m-d', '2000-01-01'),
                'address' => $faker->address,
                'religion' => 'Islam',
                'marital_status' => $faker->randomElement(['single', 'married', 'divorced']),
                'occupation' => 'Wiraswasta',
                'phone' => $faker->numerify('08##########'),
                'status' => 'active',
                'rw_unit_id' => $rwUnits->random()->id,
                'rt_unit_id' => $rtUnits->random()->id,
            ]);

            // 3. Buat Pengaduan (Disesuaikan dengan migration Anda)
            if ($i <= 15) {
                Complain::create([
                    'resident_id' => $resident->id,
                    'title' => $faker->randomElement([
                        'Lampu Jalan Mati', 
                        'Jalan Berlubang', 
                        'Sampah Menumpuk', 
                        'Keamanan Lingkungan'
                    ]),
                    'content' => $faker->paragraph(3), // Sesuai kolom 'content'
                    'status' => $faker->randomElement(['new', 'processing', 'completed']), // Sesuai ENUM di migration
                    'reported_date' => $faker->dateTimeBetween('-7 days', 'now'), // Sesuai kolom 'reported_date'
                    'foto_proof' => null,
                ]);
            }
        }

        $this->command->info('Berhasil meng-generate 20 penduduk dan 15 pengaduan!');
    }
}
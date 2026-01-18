<?php

namespace Database\Seeders;

use App\Models\RwUnit;
use App\Models\RtUnit;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        // Buat Data RW 01
        $rw1 = RwUnit::create(['number' => '01', 'description' => 'RW 01 Dusun Krajan']);
        
        // Buat Data RT di dalam RW 01
        RtUnit::create(['rw_unit_id' => $rw1->id, 'number' => '01']);
        RtUnit::create(['rw_unit_id' => $rw1->id, 'number' => '02']);
        RtUnit::create(['rw_unit_id' => $rw1->id, 'number' => '03']);

        // Buat Data RW 02
        $rw2 = RwUnit::create(['number' => '02', 'description' => 'RW 02 Dusun Kidul']);
        
        // Buat Data RT di dalam RW 02
        RtUnit::create(['rw_unit_id' => $rw2->id, 'number' => '01']);
        RtUnit::create(['rw_unit_id' => $rw2->id, 'number' => '02']);
    }
}
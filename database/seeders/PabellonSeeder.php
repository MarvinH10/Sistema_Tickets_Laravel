<?php

namespace Database\Seeders;

use App\Models\Pabellon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PabellonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pabellon::create([
            'sed_id'=> 1,
            'pab_nombre' => 'Pabellon 1',
            'pab_activo' => true,
        ]);

        Pabellon::create([
            'sed_id'=> 2,
            'pab_nombre' => 'Pabellon 2',
            'pab_activo' => true,
        ]);

        Pabellon::create([
            'sed_id'=> 3,
            'pab_nombre' => 'Pabellon 3',
            'pab_activo' => true,
        ]);
    }
}

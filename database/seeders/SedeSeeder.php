<?php

namespace Database\Seeders;

use App\Models\Sede;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sede::create([
            'sed_nombre' => 'Sede Tingo María',
            'sed_activo' => true,
        ]);

        Sede::create([
            'sed_nombre' => 'Sede Huánuco Esperanza',
            'sed_activo' => true,
        ]);

        Sede::create([
            'sed_nombre' => 'Sede Huánuco Centro',
            'sed_activo' => true,
        ]);
    }
}

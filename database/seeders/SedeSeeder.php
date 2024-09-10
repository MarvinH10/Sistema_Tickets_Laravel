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
            'sed_direccion' => 'Av. Tito Jaime #1514',
            'sed_ciudad' => 'Tingo María',
            'sed_telefono' => 987654321,
            'sed_activo' => true,
        ]);

        Sede::create([
            'sed_nombre' => 'Sede Huánuco Esperanza',
            'sed_direccion' => 'La Esperanza',
            'sed_ciudad' => 'Huánuco',
            'sed_telefono' => 978456123,
            'sed_activo' => true,
        ]);

        Sede::create([
            'sed_nombre' => 'Sede Huánuco Centro',
            'sed_direccion' => 'Jr. Hermilio Valdizan #1514',
            'sed_ciudad' => 'Huánuco',
            'sed_telefono' => 985647123,
            'sed_activo' => true,
        ]);
    }
}

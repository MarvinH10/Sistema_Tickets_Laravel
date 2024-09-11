<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::create([
            'rol_nombre' => 'Admin',
            'rol_activo' => true,
        ]);

        Rol::create([
            'rol_nombre' => 'Soporte',
            'rol_activo' => true,
        ]);

        Rol::create([
            'rol_nombre' => 'Docente',
            'rol_activo' => true,
        ]);
    }
}

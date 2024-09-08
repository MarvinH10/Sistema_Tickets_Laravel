<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Marvin Campos Deza',
            'email' => '2019110448@udh.edu.pe',
            'password' => Hash::make('987654321'),
            'telefono' => '987654321',
            'activo' => true,
            'rol_id' => 1,
            'sed_id' => 1,
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'telefono' => '987654322',
            'activo' => true,
            'rol_id' => 2,
            'sed_id' => 2,
        ]);

        User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => Hash::make('password123'),
            'telefono' => '987654323',
            'activo' => true,
            'rol_id' => 3,
            'sed_id' => 3,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario admin
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin1234'),
            ]
        );

        // Crear usuario de prueba
        User::firstOrCreate(
            ['email' => 'ev8503777@gmail.com'],
            [
                'name' => 'Eva',
                'password' => Hash::make('12345678'),
            ]
        );

        // Sembrar tenis
        $this->call(TenisSeeder::class);
    }
}

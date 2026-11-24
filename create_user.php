<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Eliminar si ya existe
User::where('email', 'ev8503777@gmail.com')->delete();

$user = User::create([
    'name' => 'Evalda',
    'email' => 'ev8503777@gmail.com',
    'password' => Hash::make('12345678'),
]);
echo "Usuario creado: " . $user->email . "\n";

// Crear admin
User::where('email', 'admin@admin.com')->delete();
$admin = User::create([
    'name' => 'Admin',
    'email' => 'admin@admin.com',
    'password' => Hash::make('admin1234'),
]);
echo "Admin creado: " . $admin->email . "\n";

// Ver cuántos tenis hay
$count = \App\Models\Tenis::count();
echo "Tenis en DB: " . $count . "\n";

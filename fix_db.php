<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

// Agregar columnas faltantes a users
if (!Schema::hasColumn('users', 'is_admin')) {
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('is_admin')->default(false);
    });
    echo "Columna is_admin agregada\n";
} else {
    echo "is_admin ya existe\n";
}

if (!Schema::hasColumn('users', 'session_id')) {
    Schema::table('users', function (Blueprint $table) {
        $table->string('session_id')->nullable();
    });
    echo "Columna session_id agregada\n";
} else {
    echo "session_id ya existe\n";
}

// Actualizar admin
\App\Models\User::where('email', 'admin@admin.com')->update(['is_admin' => true]);
echo "Admin actualizado\n";

// Verificar
$user = \App\Models\User::where('email', 'ev8503777@gmail.com')->first();
echo "Usuario: " . $user->email . " | is_admin: " . ($user->is_admin ? 'si' : 'no') . "\n";
echo "FIN OK\n";

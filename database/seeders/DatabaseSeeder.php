<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() {
    \App\Models\User::create([
        'uuid' => Str::uuid(),
        'nom' => 'Sekaro',
        'prenom' => 'Ramadane',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('Admin123'), // Mot de passe complexe
        'role' => 'admin',
        'email_verifie_le' => now(),
    ]);
}
}

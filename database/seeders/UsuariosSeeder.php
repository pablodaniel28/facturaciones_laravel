<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'marcela',
            'huella' => 'marcela123',
            'email' => 'marcela@gmail.com',
            'password' => Hash::make('12345678'), // Asegúrate de hashear las contraseñas
        ]);

        // Añade más usuarios si es necesario
        User::create([
            'name' => 'jorge',
            'huella' => 'jorge123',
            'email' => 'jorge@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}

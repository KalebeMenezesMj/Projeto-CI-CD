<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@floresesonhos.com.br',
            'password' => Hash::make('admin123'),
            'phone' => '(11) 99999-0000',
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@teste.com',
            'password' => Hash::make('cliente123'),
            'phone' => '(11) 98888-1111',
            'is_admin' => false,
        ]);
    }
}

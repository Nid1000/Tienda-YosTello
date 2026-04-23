<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Admin::query()->updateOrCreate(
            ['email' => 'admin@novawear.test'],
            [
                'name' => 'Administrador YO-TELLO',
                'password' => Hash::make('Admin12345'),
                'is_active' => true,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'cliente@novawear.test'],
            [
                'name' => 'Cliente Demo',
                'password' => Hash::make('Cliente12345'),
                'role' => 'customer',
            ]
        );
    }
}

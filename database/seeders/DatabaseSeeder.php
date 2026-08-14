<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Nhume Admin',
            'email'    => 'admin@nhume.co.zw',
            'password' => Hash::make('password'),
            'role'     => UserRole::Admin,
        ]);

        // Test sender
        User::create([
            'name'     => 'Test Sender',
            'email'    => 'sender@nhume.co.zw',
            'password' => Hash::make('password'),
            'role'     => UserRole::Sender,
        ]);

        $this->call([
            TransporterSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed akun demo Pemilik & Staf Kasir FroShelf (UMKM Frozen Shelly).
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'pemilik@froshelf.test'],
            [
                'name' => 'Ibu Shelly',
                'password' => Hash::make('password'),
                'role' => 'pemilik',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staf@froshelf.test'],
            [
                'name' => 'Staf Kasir 1',
                'password' => Hash::make('password'),
                'role' => 'staf',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staf2@froshelf.test'],
            [
                'name' => 'Staf Kasir 2',
                'password' => Hash::make('password'),
                'role' => 'staf',
                'email_verified_at' => now(),
            ]
        );
    }
}

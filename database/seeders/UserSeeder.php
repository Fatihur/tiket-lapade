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
            'name' => 'Administrator',
            'email' => 'lapadetiket@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
            'nomor_telepon' => '081234567890',
            'aktif' => true,
        ]);

        User::create([
            'name' => 'Petugas Tiket',
            'email' => 'petugas@wisata.com',
            'password' => Hash::make('password'),
            'role' => 'Petugas',
            'nomor_telepon' => '081234567891',
            'aktif' => true,
        ]);

        User::create([
            'name' => 'Bendahara',
            'email' => 'bendahara@wisata.com',
            'password' => Hash::make('password'),
            'role' => 'Bendahara',
            'nomor_telepon' => '081234567892',
            'aktif' => true,
        ]);

        User::create([
            'name' => 'Owner Wisata',
            'email' => 'owner@wisata.com',
            'password' => Hash::make('password'),
            'role' => 'Owner',
            'nomor_telepon' => '081234567893',
            'aktif' => true,
        ]);
    }
}

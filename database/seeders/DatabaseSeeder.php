<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\TenagaMedis;
use App\Models\SuperAdmin;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder default user (opsional)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        SuperAdmin::create([
            'username' => 'superadmin1',
            'name' => 'Super Administrator Satu',
            'email' => 'superadmin1@example.com',
            'password' => Hash::make('password123'),
        ]);

        SuperAdmin::create([
            'username' => 'superadmin2',
            'name' => 'Super Administrator Dua',
            'email' => 'superadmin2@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Seeder Admin (minimal 2)
        Admin::create([
            'username' => 'admin1',
            'name' => 'Admin Satu',
            'email' => 'admin1@example.com',
            'password' => Hash::make('admin123'),
        ]);

        Admin::create([
            'username' => 'admin2',
            'name' => 'Admin Dua',
            'email' => 'admin2@example.com',
            'password' => Hash::make('admin123'),
        ]);

        // Seeder Tenaga Medis (minimal 2)
        TenagaMedis::create([
            'username' => 'dokter1',
            'name' => 'Dokter Pertama',
            'email' => 'dokter1@example.com',
            'password' => Hash::make('dokter123'),
        ]);

        TenagaMedis::create([
            'username' => 'perawat1',
            'name' => 'Perawat Satu',
            'email' => 'perawat1@example.com',
            'password' => Hash::make('perawat123'),
        ]);

    }
}

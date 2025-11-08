<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * 1️⃣ Permission untuk semua modul di sistem Wali Care
         */
        $permissions = [
            // Program Donasi
            'view programs',
            'create programs',
            'edit programs',
            'delete programs',
            'manage programs',

            // Donasi & Transaksi
            'view donations',
            'verify donations',
            'manage transactions',

            // Penerima Manfaat
            'view beneficiaries',
            'create beneficiaries',
            'edit beneficiaries',
            'delete beneficiaries',

            // Laporan & Akuntabilitas
            'view reports',
            'export reports',

            // Manajemen Pengguna
            'manage users',
            'assign roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /**
         * 2️⃣ Buat Role utama
         */
        $superadmin = Role::firstOrCreate(['name' => 'Superadmin']);
        $programManager = Role::firstOrCreate(['name' => 'Program Manager']);
        $finance = Role::firstOrCreate(['name' => 'Finance']);
        $verifikator = Role::firstOrCreate(['name' => 'Verifikator']);
        $contentEditor = Role::firstOrCreate(['name' => 'Content Editor']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        /**
         * 3️⃣ Berikan Permission untuk setiap Role
         */
        $superadmin->syncPermissions(Permission::all());

        $programManager->syncPermissions([
            'view programs',
            'create programs',
            'edit programs',
            'delete programs',
            'manage programs',
            'view beneficiaries',
            'create beneficiaries',
            'edit beneficiaries',
            'delete beneficiaries',
            'view reports',
        ]);

        $finance->syncPermissions([
            'view donations',
            'verify donations',
            'manage transactions',
            'view reports',
            'export reports',
        ]);

        $verifikator->syncPermissions([
            'verify donations',
            'view programs',
        ]);

        $contentEditor->syncPermissions([
            'view programs',
            'create programs',
            'edit programs',
        ]);

        $userRole->syncPermissions([
            'view programs',
            'view donations',
        ]);

        /**
         * 4️⃣ Buat akun untuk setiap role
         */

        // Superadmin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($superadmin);

        // Program Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'Program Manager',
                'password' => Hash::make('password'),
            ]
        );
        $manager->assignRole($programManager);

        // Finance
        $financeUser = User::firstOrCreate(
            ['email' => 'finance@gmail.com'],
            [
                'name' => 'Finance Officer',
                'password' => Hash::make('password'),
            ]
        );
        $financeUser->assignRole($finance);

        // Verifikator
        $verif = User::firstOrCreate(
            ['email' => 'verifikator@gmail.com'],
            [
                'name' => 'Verifikator Donasi',
                'password' => Hash::make('password'),
            ]
        );
        $verif->assignRole($verifikator);

        // Content Editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@gmail.com'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('password'),
            ]
        );
        $editor->assignRole($contentEditor);

        // Donatur / User biasa
        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User Biasa',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole($userRole);

        $this->command->info('✅ UserSeeder: Semua Role, Permission, dan Akun Awal telah dibuat untuk Wali Care.');
    }
}

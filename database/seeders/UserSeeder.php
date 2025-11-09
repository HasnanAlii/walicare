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
        
        $permissions = [
            'view programs',
            'create programs',
            'edit programs',
            'delete programs',
            'manage programs',

            'view donations',
            'verify donations',
            'manage transactions',

            'view beneficiaries',
            'create beneficiaries',
            'edit beneficiaries',
            'delete beneficiaries',

            'view reports',
            'export reports',

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
        $userRole = Role::firstOrCreate(['name' => 'User']);

        /**
         * 3️⃣ Berikan Permission untuk setiap Role
         */
        $superadmin->syncPermissions(Permission::all());

  

        $userRole->syncPermissions([
            'view programs',
            'view donations',
        ]);

      
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($superadmin);

        
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

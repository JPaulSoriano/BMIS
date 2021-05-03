<?php

namespace Database\Seeders;

use Hash;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $superAdmin = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@bmis.com',
            'email_verified_at' => now(),
            'password' => 'superadmin12345',
        ]);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@bmis.com',
            'email_verified_at' => now(),
            'password' => 'admin12345',
        ]);

        $superAdminRole = Role::create(['name' => 'superadmin']);
        $adminRole = Role::create(['name' => 'admin']);
        Role::create(['name' => 'passenger']);
        Role::create(['name' => 'operation']);
        Role::create(['name' => 'conductor']);
        Role::create(['name' => 'driver']);

        $superAdmin->assignRole($superAdminRole);
        $admin->assignRole($adminRole);
    }
}

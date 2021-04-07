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
            'first_name' => 'superadmin',
            'last_name' => 'superadmin',
            'email' => 'superadmin@bmis.com',
            'email_verified_at' => now(),
            'password' => 'superadmin12345',
        ]);

        $admin = User::create([
            'name' => 'admin',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@bmis.com',
            'email_verified_at' => now(),
            'password' => 'admin12345',
        ]);

        $passenger = User::create([
            'name' => 'passenger',
            'first_name' => 'passenger',
            'last_name' => 'passenger',
            'email' => 'passenger@bmis.com',
            'email_verified_at' => now(),
            'password' => 'passenger12345',
        ]);

        $conductor = User::create([
            'name' => 'conductor',
            'first_name' => 'conductor',
            'last_name' => 'conductor',
            'email' => 'conductor@bmis.com',
            'email_verified_at' => now(),
            'password' => 'conductor12345',
        ]);

        $superAdminRole = Role::create(['name' => 'superadmin']);
        $adminRole = Role::create(['name' => 'admin']);
        $passengerRole = Role::create(['name' => 'passenger']);
        $conductorRole = Role::create(['name' => 'conductor']);

        $superAdmin->assignRole($superAdminRole);
        $admin->assignRole($adminRole);
        $passenger->assignRole($passengerRole);
        $conductor->assignRole($conductorRole);
    }
}

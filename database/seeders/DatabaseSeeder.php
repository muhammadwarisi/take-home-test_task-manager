<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Membuat role 'admin' dan 'user'
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'User']);

        // Membuat permission CRUD untuk User
        $permissions = ['Create', 'Read', 'Update', 'Delete'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Membuat user admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin1234'), // Ganti dengan password yang diinginkan
        ]);
        $admin->assignRole('Admin');
        $admin->givePermissionTo($permissions);

        // Membuat user biasa
        $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('user1234'), // Ganti dengan password yang diinginkan
        ]);
        $user->assignRole('User');
        $user->givePermissionTo(['Read']);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define Permissions

        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',

            'create-user',
            'edit-user',
            'delete-user',

            'create-books',
            'view-books',
            'edit-books',
            'delete-books',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $product_manager = Role::create(['name' => 'Product Manager']);
        $user = Role::create(['name' => 'User']);

        // Assign Permission
        $admin->givePermissionTo(['create-user', 'edit-user', 'delete-user', 'create-books', 'view-books', 'edit-books', 'delete-books']);
        $product_manager->givePermissionTo('view-books', 'create-books', 'edit-books');
        $user->givePermissionTo('view-books');
        
    }
}

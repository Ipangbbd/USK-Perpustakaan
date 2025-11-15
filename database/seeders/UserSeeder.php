<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@gmail.com',
            'password' => Hash::make('Super12345')
        ]);
        $superAdmin->assignRole('Super Admin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin12345')
        ]);
        $admin->assignRole('Admin');

        $productManager = User::create([
            'name' => 'Product Manager',
            'email' => 'productmanager@gmail.com',
            'password' => Hash::make('ProductManager12345')
        ]);
        $productManager->assignRole('Product Manager');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('User12345')
        ]);
        $user->assignRole('User');
    }
}

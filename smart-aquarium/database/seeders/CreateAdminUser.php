<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Seeder
{
    public function run()
    {
        // Hapus user admin yang mungkin sudah ada
        User::where('email', 'admin@admin.com')->delete();

        // Buat user admin baru
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        echo "Admin user created successfully!\n";
        echo "Email: admin@admin.com\n";
        echo "Password: admin123\n";
    }
} 
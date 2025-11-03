<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Buat default admin user
        $user = User::create([
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Buat admin profile
        Admin::create([
            'user_id' => $user->user_id,
            'nama_lengkap' => 'Administrator IQRAIN',
        ]);

        // Assign rolenya admin
        $user->assignRole('admin');
    }
}

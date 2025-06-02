<?php
// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name'     => 'Admin Demo',
            'email'    => 'admin@demo.com',
            'password' => 'admin123', // akan di‐hash otomatis
            'role'     => 'admin',    // jika ada kolom role
        ]);
    }
}

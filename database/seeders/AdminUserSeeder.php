<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@maildrop.cc',
            'password' => Hash::make('admin12345'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Superadmin User',
            'email' => 'jyhosang@gmail.com',
            'password' => Hash::make('Jolevin_01'),
            'email_verified_at' => now(),
            'role' => 'superadmin',
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@maildrop.cc');
        $this->command->info('Password: admin12345');
        $this->command->info('Superadmin user created successfully!');
        $this->command->info('Email: jyhosang@gmail.com');
        $this->command->info('Password: Jolevin_01');
    }
}

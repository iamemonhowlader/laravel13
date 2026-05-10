<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'      => 'Super Admin',
                'email'     => 'admin@admin.com',
                'password'  => Hash::make('12345678'),
                'role'      => 'superadmin',
                'is_active' => true,
            ]
        );

        $this->command->info('Admin created: admin@admin.com / 12345678');
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '9876543210',
            'password' => Hash::make('housewares'),
            'roles' => 2
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'phone' => '0123456789',
            'password' => Hash::make('housewares'),
            'roles' => 1
        ]);

    }
}

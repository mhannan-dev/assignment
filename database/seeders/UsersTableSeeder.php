<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $adminsRecord = [
            [
                'name' => 'Admin User', 'type' => 'admin',  'email' => 'admin@admin.com','email_verified_at' => now(), 'password' => Hash::make('password'), 'remember_token' => Str::random(10)
            ],
            [
                'name' => 'Manger User', 'type' => 'manager', 'email' => 'manager@admin.com', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'remember_token' => Str::random(10)
            ]
        ];
        DB::table('users')->insert($adminsRecord);
    }
}

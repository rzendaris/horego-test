<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'User Super Admin',
            'email' => 'super.admin@gmail.com',
            'password' => bcrypt('pass@admin'),
        ]);
        
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'User Account Manager 1',
            'email' => 'manager1@gmail.com',
            'password' => bcrypt('pass@manager'),
        ]);
        
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'User Account Manager 2',
            'email' => 'manager2@gmail.com',
            'password' => bcrypt('pass@manager'),
        ]);
    }
}

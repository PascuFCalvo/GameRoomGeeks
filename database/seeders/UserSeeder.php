<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                'name' => Str::random(10),
                'nick' => 'admin00',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'roles' => "admin"
            ]
        );

        DB::table('users')->insert(
            [
                'name' => Str::random(10),
                'nick' => 'superadmin01',
                'email' => 'superadmin@superadmin.com',
                'password' => Hash::make('password'),
                'roles' => "superadmin"
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Paco',
                'nick' => 'SuperPaco',
                'email' => 'paco@paco.com',
                'password' => Hash::make('password'),
                'roles' => "user"
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Loli',
                'nick' => 'HotLoli',
                'email' => 'loli@loli.com',
                'password' => Hash::make('password'),
                'roles' => "user"
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Pepe',
                'nick' => 'PepeNeitor',
                'email' => 'pepe@pepe.com',
                'password' => Hash::make('password'),
                'roles' => "user"
            ]
        );
    }
}

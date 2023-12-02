<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('members')->insert(
            [
                
                'user_id' => 1,
                'room_id' => 2,
            ]
        );

        DB::table('members')->insert(
            [
                
                'user_id' => 1,
                'room_id' => 1,
            ]
        );

        DB::table('members')->insert(
            [
                
                'user_id' => 2,
                'room_id' => 2,
            ]
        );

        DB::table('members')->insert(
            [
                
                'user_id' => 1,
                'room_id' => 3,
            ]
        );

        DB::table('members')->insert(
            [
                
                'user_id' => 3,
                'room_id' => 2,
            ]
        );
    }
}

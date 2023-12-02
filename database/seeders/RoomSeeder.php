<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('room')->insert(
            [
                'name' => 'Room del superMario',
                'room_owner' => 1,
                'videogame_id' => 1,
            ]
        );

        DB::table('room')->insert(
            [
                'name' => 'Room del Hitman',
                'room_owner' => 1,
                'videogame_id' => 2,
            ]
        );

        DB::table('room')->insert(
            [
                'name' => 'Awesome mega room',
                'room_owner' => 1,
                'videogame_id' => 1,
            ]
        );
    }
}

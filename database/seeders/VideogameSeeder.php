<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideogameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('videogames')->insert(
            [
                'name' => 'mario bros',
                'user_id' => 1,
            ]
        );

        DB::table('videogames')->insert(
            [
                'name' => 'hitman',
                'user_id' => 1,
            ]
        );

        DB::table('videogames')->insert(
            [
                'name' => 'sims 3',
                'user_id' => 1,
            ]
        );
    }
}

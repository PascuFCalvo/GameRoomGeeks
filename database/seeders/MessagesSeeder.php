<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('messages')->insert(
            [

                'user_id' => 1,
                'room_id' => 1,
                'content' => 'Hola, soy el superadmin01',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 2,
                'room_id' => 1,
                'content' => 'juegazo el mario bros',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 3,
                'room_id' => 1,
                'content' => 'busco gente para jugar',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 3,
                'room_id' => 1,
                'content' => 'alguien se apunta?',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 1,
                'room_id' => 2,
                'content' => 'Bievenidos a la room del hitman',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 2,
                'room_id' => 2,
                'content' => 'alguien se ha pasado el juego?',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 3,
                'room_id' => 2,
                'content' => 'como se mata al jefe final?',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 3,
                'room_id' => 2,
                'content' => 'lol es muy dificl esta vaina',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 1,
                'room_id' => 3,
                'content' =>'Estamos en la sala awesome mega room',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 2,
                'room_id' => 3,
                'content' => 'que me recomendais para jugar?',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 3,
                'room_id' => 3,
                'content' => 'que estilo te gusta?',
            ]
        );

        DB::table('messages')->insert(
            [

                'user_id' => 3,
                'room_id' => 3,
                'content' => 'a mi me flipan los shooters',
            ]
        );
    }
}

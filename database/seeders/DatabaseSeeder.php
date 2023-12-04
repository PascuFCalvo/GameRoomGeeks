<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        $this->call([
            VideogameSeeder::class,
        ]);

        $this->call([
            RoomSeeder::class,
        ]);

        $this->call([
            MembersSeeder::class,
        ]);

        $this->call([
            MessagesSeeder::class,
        ]);



        \App\Models\User::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

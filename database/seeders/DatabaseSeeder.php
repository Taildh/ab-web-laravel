<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->truncate();

         \App\Models\User::factory()->create([
             'name' => 'ArtBox',
             'email' => 'artbox.corp@gmail.com',
             'password' => bcrypt('password'),
         ]);
    }
}

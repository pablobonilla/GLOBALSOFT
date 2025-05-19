<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'name' => "Hamlet jimenez",
            'email' => "admin@admin.com",
            'password' => '$2y$10$TPpUJwKBQPtj5XJJ.wx3AeCHpVUKoJjM.d1m5bgv6vp5MTMuMByYm'
        ]);
    }
}

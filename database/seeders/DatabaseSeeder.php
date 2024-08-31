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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::create([
            'nama' => 'Adi',
            'email' => 'adi@gmail.com',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => date('Y-m-d'),
            'tempat_lahir' => 'Pekalongan',
            'alamat' => 'Jl. qwerty 123',
            'level' => 0,
            'password' => bcrypt('user123')
        ]);
    }
}

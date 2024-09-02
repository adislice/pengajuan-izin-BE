<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Izin;
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
        \App\Models\User::create([
            'nama' => 'Reza',
            'email' => 'reza@gmail.com',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => date('Y-m-d'),
            'tempat_lahir' => 'Pekalongan',
            'alamat' => 'Jl. qwerty 123',
            'level' => 1,
            'password' => bcrypt('user123')
        ]);
        \App\Models\User::create([
            'nama' => 'Cindy',
            'email' => 'cindy@gmail.com',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => date('Y-m-d'),
            'tempat_lahir' => 'Pekalongan',
            'alamat' => 'Jl. qwerty 123',
            'level' => 2,
            'password' => bcrypt('user123')
        ]);

        Izin::create([
            'user_id' => 3,
            'tanggal_mulai' => date('Y-m-d'),
            'tanggal_selesai' => date('Y-m-d'),
            'jenis_izin' => 'Sakit',
            'alasan' => 'Saya sakit',
            'status' => 'diajukan'
        ]);
    }
}

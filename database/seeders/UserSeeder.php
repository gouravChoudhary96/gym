<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Gourav',
            'email' => 'gourav@gmail.com'
        ]);
        User::factory()->create([
            'name' => 'khushi',
            'email' => 'khusi@gmail.com'
        ]);
        User::factory()->create([
            'name' => 'Ankur',
            'email' => 'Ankur@gmail.com',
            'role' => 'instructor'
        ]);
        User::factory()->create([
            'name' => 'Uttam',
            'email' => 'uttam@gmail.com',
            'role' => 'instructor'
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        User::factory()->count(10)->create();

        //  For instruuctor

        user::factory()->count(10)->create([
            'role' => 'instructor',
        ]);
        //  For admin
        user::factory()->count(1)->create([
            'role' => 'admin',
        ]);
    }
}

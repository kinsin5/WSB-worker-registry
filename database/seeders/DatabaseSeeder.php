<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'user1',
            'email' => 'user@wp.pl',
            'password' => 'haslohaslo',
            'role' => 'employee',
        ]);

        User::factory()->create([
            'name' => 'supervisor1',
            'email' => 'super@wp.pl',
            'password' => 'haslohaslo',
            'role' => 'supervisor',
        ]);
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@wp.pl',
            'password' => 'haslohaslo',
            'role' => 'admin',
        ]);

        User::factory(10)->create();

        // User::factory()->create([
        //     'name' => fake('pl_PL')->name(),
        //     'email' => 'test@example.com',
        // ]);
    }
}

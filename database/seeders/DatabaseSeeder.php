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
    \App\Models\Post::factory()->count(20)->create([
        'status' => 'published',
        'content' => fake()->paragraph(),
        'title' => fake()->sentence(),
    ]);
}
}

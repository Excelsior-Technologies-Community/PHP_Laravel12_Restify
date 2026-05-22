<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::create([
            'title' => 'Getting Started with Laravel',
            'content' => 'Laravel is a powerful PHP framework that makes development enjoyable...',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Post::create([
            'title' => 'Understanding Eloquent ORM',
            'content' => 'Eloquent provides an active record implementation for working with your database...',
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
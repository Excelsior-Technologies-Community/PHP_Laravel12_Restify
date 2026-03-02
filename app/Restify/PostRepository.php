<?php

namespace App\Restify;

use App\Models\Post;
use Illuminate\Http\Request;
use Binaryk\LaravelRestify\Repositories\Repository;
use Binaryk\LaravelRestify\Fields\Field;

class PostRepository extends Repository
{
    public static string $model = Post::class;

    public function fields(Request $request): array
    {
        return [

            Field::make('id')->readonly(),

            Field::make('title')
                ->rules('required')
                ->sortable()
                ->searchable(),

            Field::make('content')
                ->rules('required'),

            Field::make('published_at'),

        ];
    }

    public static function authorizedToStore(Request $request): bool
    {
        return true;
    }

    public function authorizedToUpdate(Request $request): bool
    {
        return true;
    }

    public function authorizedToDelete(Request $request): bool
    {
        return true;
    }
}
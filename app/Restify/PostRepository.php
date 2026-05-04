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
                ->rules('required', 'max:255')
                ->sortable()
                ->searchable(),

            Field::make('content')
                ->rules('required', 'min:10')
                ->searchable(),

            Field::make('status')
                ->rules('required', 'in:draft,published')
                ->sortable(),

            Field::make('published_at')
                ->sortable(),
        ];
    }

    /**
     *  THIS FIXES STATUS FILTER
     */
    public static function indexQuery(Request $request, $query)
    {
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query;
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
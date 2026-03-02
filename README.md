# PHP_Laravel12_Restify


## Project Description

PHP_Laravel12_Restify is a RESTful API boilerplate built with Laravel 12 and Laravel Restify.
It demonstrates how to quickly create API endpoints for managing resources such as posts, with CRUD functionality (Create, Read, Update, Delete).

This project is ideal for beginners or developers who want a ready-to-use API backend structure in Laravel 12.




## Features

- Repository pattern for API structure (via Restify).

- Validation rules for API input fields.

- Authorization methods (can be customized per user).

- JSON:API compliant responses with data and attributes.

- Easily extendable to add more models and repositories.

- Optional integration with RestifyJS for front-end usage.



## Technologies Used

1. Laravel 12 – PHP web framework for building robust applications.

2. Laravel Restify – A package for building REST APIs quickly and efficiently.

3. MySQL – Relational database to store data.

4. PHP 8.2+ – Latest stable version of PHP.

5. Composer – Dependency manager for PHP packages.

6. Postman / Browser – For testing API endpoints.

---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Restify "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Restify

```

#### Explanation:

Installs a fresh Laravel 12 project and navigates into the project folder.





## STEP 2: Database Setup 

### Open .env and set:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_restify
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_restify

```

### Run migration:

```
php artisan migrate

```



#### Explanation:

This connects your Laravel app to MySQL to store any future data.





## STEP 3: Install Laravel Restify Package

### Run command:

```
composer require binaryk/laravel-restify

```

#### Explanation:

Installs the Restify package, which simplifies building RESTful APIs in Laravel.





## STEP 4: Setup Restify

### Run command:

```
php artisan restify:setup

```

### This will create:

```
config/restify.php

app/Restify/

```

#### Explanation:

Generates the Restify configuration file and repository folder structure for your API resources.





## STEP 5: Create Model and Migration

### Run:

```
php artisan make:model Post -m

```

### Edit Migration File

#### Open: database/migrations/xxxx_create_posts_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

```


### Run migration:

```
php artisan migrate

```

#### Explanation:

Creates the Post model and database table with fields title, content, published_at, and timestamps.





## STEP 6: Create Restify Repository

### Run command:

```
php artisan restify:repository PostRepository --all

```

### This creates:

```
app/Restify/PostRepository.php

```

#### Explanation:

Generates a repository that connects the Post model to Restify, enabling CRUD operations via API.





## STEP 7: Configure Repository

### Open: app/Restify/PostRepository.php

#### Replace with:

```
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

```

#### Explanation:

Defines which fields are available in the API, their validation rules, and authorizations for CRUD operations.





## STEP 8: Edit Model

### Open: App/Models/Post.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'title',
        'content',
        'published_at',
    ];

}

```

#### Explanation:

Sets the $fillable fields so Laravel can mass assign values when creating or updating posts.




## STEP 9: config/restify.php (Laravel 12 working)

### File: config/restify.php

```
<?php

use Binaryk\LaravelRestify\Repositories\ActionLogRepository;

return [

    /*
    |--------------------------------------------------------------------------
    | Auth Configuration
    |--------------------------------------------------------------------------
    */

    'auth' => [

        'table' => 'users',

        'provider' => 'sanctum',

        'frontend_app_url' => env('FRONTEND_APP_URL', env('APP_URL')),

        'password_reset_url' => env('FRONTEND_APP_URL').'/password/reset?token={token}&email={email}',

        'user_verify_url' => env('FRONTEND_APP_URL').'/verify/{id}/{emailHash}',

        'user_model' => \App\Models\User::class,

        'token_ttl' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | RestifyJS
    |--------------------------------------------------------------------------
    */

    'restifyjs' => [

        'token' => env('RESTIFYJS_TOKEN', 'testing'),

        'api_url' => env('API_URL', env('APP_URL')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Base Route
    |--------------------------------------------------------------------------
    */

    'base' => '/api/restify',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    | IMPORTANT: Empty to avoid 403 error
    */

    'middleware' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Logs
    |--------------------------------------------------------------------------
    */

    'logs' => [

        'repository' => ActionLogRepository::class,

        'enable' => true,

        'all' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    'search' => [

        'case_sensitive' => false,

        'use_joins_for_belongs_to' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Register Repositories HERE (IMPORTANT)
    |--------------------------------------------------------------------------
    */

    'repositories' => [

        'collectors' => [

            App\Restify\PostRepository::class,

        ],

        'serialize_index_meta' => false,

        'serialize_show_meta' => true,

        'cache' => [

            'enabled' => false,

            'ttl' => 300,

            'store' => null,

            'skip_authenticated' => false,

            'enable_in_tests' => false,

            'tags' => ['restify'],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    */

    'cache' => [

        'policies' => [

            'enabled' => false,

            'ttl' => 300,
        ],
    ],

];

```

#### Explanation:

Configures Restify settings like authentication, base API route, repositories, caching, and logs.






## STEP 10: Start Server

### Run:

```
php artisan serve

```

#### Explanation:

Starts the Laravel development server so you can test your API in browser or Postman.




## STEP 11: Test API in Browser or Postman


### Create Post

1. Method: POST

2. URL:

```
http://127.0.0.1:8000/api/restify/posts

```

3. Body:

```
{
    "title": "First Post",
    "content": "This is first post",
    "published_at": "2026-01-01"
}

```

#### Output:


<img width="1428" height="900" alt="Screenshot 2026-03-02 121111" src="https://github.com/user-attachments/assets/cf306e8d-e12e-4b9a-a185-41c8e5f477a2" />



### Get All Posts

1. Method: GET

2. URL:

```
http://127.0.0.1:8000/api/restify/posts

```

#### Output:


<img width="1431" height="893" alt="Screenshot 2026-03-02 121213" src="https://github.com/user-attachments/assets/b7468bbb-5507-4805-9a41-4b06044c6c5b" />




### Get Single Post

1. Method: GET

2. URL:

```
http://127.0.0.1:8000/api/restify/posts/1

```

#### Output:


<img width="1435" height="931" alt="Screenshot 2026-03-02 121237" src="https://github.com/user-attachments/assets/7ef252a7-6f41-4280-b638-cb18d3f7eaf9" />







---

# Project Folder Structure:

```
PHP_Laravel12_Restify
│
├── app
│   ├── Models
│   │    └── Post.php          # Eloquent model
│   │
│   └── Restify
│        └── PostRepository.php # Restify repository for API
│
├── config
│   └── restify.php             # Restify configuration
│
├── database
│   └── migrations              # Table migrations
│
├── routes                      # Route files (web.php, api.php)
│
└── vendor                      # Composer dependencies

```

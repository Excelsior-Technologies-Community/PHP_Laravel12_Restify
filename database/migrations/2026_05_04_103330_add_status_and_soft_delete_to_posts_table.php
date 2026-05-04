<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {

            //  Add status column
            $table->enum('status', ['draft', 'published'])
                  ->default('draft')
                  ->after('content');

            // Add soft delete column
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {

            $table->dropColumn('status');
            $table->dropSoftDeletes();

        });
    }
};
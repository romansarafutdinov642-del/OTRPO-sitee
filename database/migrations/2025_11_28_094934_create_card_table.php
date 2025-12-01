<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category'); // Фильмы или Награды
            $table->text('description');
            $table->text('details');
            $table->string('image_path')->nullable();
            $table->string('fun_fact_content')->nullable();
            $table->string('director')->nullable();
            $table->year('release_year')->nullable();
            $table->string('genre')->nullable();
            $table->decimal('imdb_rating', 3, 1)->nullable();
            $table->date('ceremony_date')->nullable();
            $table->string('award_category')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};

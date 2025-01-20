<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news_url', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500)->unique();
            $table->string('url_slug', 250)->unique();
            $table->string('title', 500);
            $table->text('desc');
            $table->string('image_url', 200)->nullable();
            $table->integer('news_user_id');
            $table->integer('likes_count');
            $table->integer('views_count');
            $table->integer('news_user_id');            
            $table->timestamps();
            $table->boolean('status')->default(true); // Kolom status boolean dengan default true (aktif)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_url');
    }
};

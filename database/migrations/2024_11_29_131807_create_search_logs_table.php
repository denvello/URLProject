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
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()
                  ->constrained('users') // Relasi ke tabel users
                  ->onDelete('set null'); // Jika user dihapus, set user_id ke NULL
            $table->string('search_keyword'); // Kata atau URL yang dicari
            $table->enum('search_type', ['word', 'numeric', 'url','product','invalid']); // Jenis pencarian: kata atau URL
            $table->integer('search_count')->default(1); // Berapa kali keyword ini dicari
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_logs');
    }
};

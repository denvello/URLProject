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
        Schema::create('products', function (Blueprint $table) {
            $table->id;  
            $table->unsignedBigInteger('product_user_id');  // Foreign Key untuk user
            //$table->product_user_id();  
            $table->string('product_name');  // Nama produk
            $table->string('product_slug')->unique()->after('product_name');
            $table->text('product_description')->nullable();  // Deskripsi produk
            $table->string('product_image1_url')->nullable();  // URL Gambar produk
            $table->string('product_image2_url')->nullable();  // URL Gambar produk
            $table->string('product_image3_url')->nullable();  // URL Gambar produk
            $table->string('product_image4_url')->nullable();  // URL Gambar produk
            $table->string('product_image5_url')->nullable();  // URL Gambar produk
            $table->string('product_image_qr')->nullable();  // URL Gambar produk
            $table->decimal('product_price', 10, 2);  // Harga produk
            $table->string('url')->unique();  // URL unik untuk produk
            $table->string('product_contact_number');
            $table->int('product_viewed');
            $table->int('product_liked');
            $table->int('product_generated_qr_count');
            $table->int('product_qr_code_scanned');
            $table->timestamps();  // Waktu dibuat dan diupdate
            //$table->foreign('product_user_id')->references('id')->on('users');  // Definisikan Foreign Key
            // Definisikan Foreign Key untuk product_user_id
            $table->foreign('product_user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

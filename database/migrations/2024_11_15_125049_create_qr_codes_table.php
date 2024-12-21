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
            Schema::create('qr_codes', function (Blueprint $table) {
                // ID unik untuk setiap QR code
                $table->id();
    
                // Menyimpan ID produk yang terkait dengan QR code ini (Foreign Key)
                $table->unsignedBigInteger('product_id');
    
                // Menyimpan URL gambar QR code yang dihasilkan
                $table->string('qr_code_image_url');
    
                // Menyimpan jumlah berapa kali QR code dipindai
                $table->integer('scanned_count')->default(0);
    
                // Waktu dibuat dan diupdate
                $table->timestamps();
    
                // Mendefinisikan Foreign Key untuk 'product_id' yang merujuk pada 'id' di tabel 'products'
                $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};

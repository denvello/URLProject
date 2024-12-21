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
        Schema::create('scans', function (Blueprint $table) {
            // ID unik untuk setiap pemindaian
            $table->id();

            // Menyimpan ID QR code yang dipindai (Foreign Key)
            $table->unsignedBigInteger('qr_code_id');
            
            // Menyimpan ID pengguna yang memindai QR code, jika ada (optional)
            $table->unsignedBigInteger('user_id')->nullable();

            // Waktu pemindaian QR code
            $table->timestamp('scanned_at')->useCurrent();

            // Menyimpan alamat IP pemindai, jika relevan
            $table->string('ip_address')->nullable();

            // Waktu dibuat dan diperbarui
            $table->timestamps();

            // // Mendefinisikan Foreign Key untuk 'qr_code_id' yang merujuk pada 'id' di tabel 'qr_codes'
            // $table->foreign('qr_code_id')->references('id')->on('qr_codes')->onDelete('cascade');

            // (Optional) Mendefinisikan Foreign Key untuk 'user_id' yang merujuk pada 'id' di tabel 'users'
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scans');
    }
};

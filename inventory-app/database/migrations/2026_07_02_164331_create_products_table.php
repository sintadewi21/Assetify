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
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('code')->unique(); // Kode Barang [cite: 54]
            $table->string('name'); // Nama Barang [cite: 56]
            $table->integer('stock'); // Stok [cite: 58]
            $table->string('location'); // Lokasi Penyimpanan [cite: 59]
            $table->string('condition'); // Kondisi Barang [cite: 60]
            $table->string('image')->nullable(); // Bonus Fitur Gambar [cite: 91]
            $table->timestamps();
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

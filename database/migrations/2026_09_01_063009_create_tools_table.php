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
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // Nama alat
            $table->string('code')->unique();        // Kode unik alat
            $table->string('category')->nullable();  // Kategori alat
            $table->integer('stock')->default(0);    // Jumlah stok
            $table->enum('condition', ['Good', 'Damaged'])->default('Good'); // Kondisi alat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
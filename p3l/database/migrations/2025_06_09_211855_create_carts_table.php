<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel 'users'. Pastikan tabel 'users' ada.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('product_id');
            $table->string('name');
            $table->decimal('price', 15, 2);
            $table->integer('quantity');
            $table->boolean('checked')->default(true);

            // Kolom tambahan untuk menyimpan detail dari frontend
            $table->string('image')->nullable();
            $table->string('store')->nullable();
            $table->string('description')->nullable();
            $table->string('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

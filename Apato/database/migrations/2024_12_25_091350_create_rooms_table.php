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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();  // auto-incrementing ID
            $table->string('name');
            $table->string('location');
            $table->decimal('rating', 3, 1);  // for example: 8.2
            $table->integer('reviews');
            $table->decimal('discounted_price', 10, 2);
            $table->decimal('original_price', 10, 2);
            $table->string('image');
            $table->string('tag')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

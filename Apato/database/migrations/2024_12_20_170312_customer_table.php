<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbcustomers', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // Ensures customers are tied to users
            $table->string('name');
            $table->string('email')->unique();
            $table->string('usertype')->default(0); 
            $table->string('phone')->nullable();
            $table->string('address')->nullable();  
            $table->string('profile_photo_path', 2048)->nullable(); 
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbcustomers');
    }
};

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
        Schema::create('picture', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->binary('picture');
            $table->foreignId('products_id')->constrained()->onUpdate('CASCADE')->onDelete('CASCADE');
           //$table->foreignId('products_user_id')->constrained()->onUpdate('CASCADE')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('picture');
    }
};

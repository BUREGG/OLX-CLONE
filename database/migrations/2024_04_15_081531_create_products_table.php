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
            $table->string('name');
            $table->string('description');
            $table->integer('price');
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->timestamp('refresh')->format('Y-m-d H:i:s')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
            $table->boolean('is_active')->default(true);
            $table->integer('views')->default(0);
            $table->foreignId('user_id')->constrained()->onUpdate('CASCADE')->onDelete('CASCADE')->nullable();
            $table->foreignId('category_id')->constrained()->onUpdate('CASCADE')->onDelete('CASCADE')->nullable();

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

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
            $table->string('title');
            $table->string('short_des');
            $table->string('long_des');
            $table->string('price');
            $table->boolean('discount');
            $table->string('discount_price');
            $table->string('image');
            $table->json('images')->nullable();
            $table->string('stock');
            $table->enum('remark', ['popular', 'new', 'top', 'special', 'trending', 'regular']);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('variation_option_id')->nullable();
            $table->foreign('variation_option_id')->references('id')->on('variation_options')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('category_id')->references('id')->on('categories')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('brand_id')->references('id')->on('brands')->restrictOnDelete()->cascadeOnUpdate();
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

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
        Schema::create('combination_options', function (Blueprint $table) {
            $table->unsignedBigInteger('product_variation_combination_id');
            $table->unsignedBigInteger('variation_option_id');

            $table->primary(['product_variation_combination_id', 'variation_option_id'], 'combination_option_primary');

            $table->foreign('product_variation_combination_id')->references('id')->on('product_variation_combinations')->cascadeOnDelete();
            $table->foreign('variation_option_id')->references('id')->on('variation_options')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combination_options');
    }
};

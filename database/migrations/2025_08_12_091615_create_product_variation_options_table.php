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
        Schema::create('product_variation_options', function (Blueprint $table) {
            $table->unsignedBigInteger('product_variation_id');
            $table->unsignedBigInteger('attribute_option_id');

            $table->primary(['product_variation_id', 'attribute_option_id'], 'variation_option_primary');

            $table->foreign('product_variation_id', 'pvo_variation_id_foreign')
                ->references('id')->on('product_variations')->cascadeOnDelete();
            $table->foreign('attribute_option_id', 'pvo_option_id_foreign')
                ->references('id')->on('attribute_options')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation_options');
    }
};

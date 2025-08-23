<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function combination()
    {
        return $this->belongsTo(ProductVariationCombination::class, 'product_variation_combination_id');
    }
}

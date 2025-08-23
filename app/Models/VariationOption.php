<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationOption extends Model
{
    protected $guarded = [];

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_variation_options');
    }

    public function combinations()
    {
        return $this->belongsToMany(ProductVariationCombination::class, 'combination_options');
    }
}

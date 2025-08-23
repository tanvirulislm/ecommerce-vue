<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariationCombination extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function options()
    {
        return $this->belongsToMany(VariationOption::class, 'combination_options');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_variation_combination_id');
    }
}

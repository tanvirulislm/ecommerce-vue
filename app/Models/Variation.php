<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $guarded = [];

    public function options()
    {
        return $this->hasMany(VariationOption::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_variation_settings');
    }
}

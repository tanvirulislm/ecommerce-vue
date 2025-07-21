<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variationOptions()
    {
        return $this->belongsToMany(VariationOption::class, 'product_variation_options')
            ->withPivot('image')
            ->with('variation');
    }
}

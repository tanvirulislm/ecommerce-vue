<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $guarded = [];

    public function variationOptions()
    {
        return $this->hasMany(VariationOption::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $guarded = [];

    public function variation_options()
    {
        return $this->hasMany(VariationOption::class);
    }
}

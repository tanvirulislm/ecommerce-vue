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
}

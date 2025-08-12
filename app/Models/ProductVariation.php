<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function options()
    {
        return $this->belongsToMany(AttributeOption::class, 'product_variation_options');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}

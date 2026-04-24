<?php

namespace App\Models;

use App\Models\DamageProduct;
use Illuminate\Database\Eloquent\Model;

class DamageProductItem extends Model
{

    protected $guarded = [];

    public function damageProduct()
    {
        return $this->belongsTo(DamageProduct::class, 'damage_product_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
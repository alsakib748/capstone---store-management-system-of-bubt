<?php

namespace App\Models;

use App\Models\DamageProductItem;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Model;

class DamageProduct extends Model
{

    protected $guarded = [];

    public function damageProductItem()
    {
        return $this->hasMany(DamageProductItem::class, 'damage_product_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }


}

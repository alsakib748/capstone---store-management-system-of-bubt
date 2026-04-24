<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Requisition;
use Illuminate\Database\Eloquent\Model;

class RequisitionItem extends Model
{

    protected $guarded = [];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
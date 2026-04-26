<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{

    protected $guarded = [];

    protected $casts = [
        'status' => 'string',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requisitionItems()
    {
        return $this->hasMany(RequisitionItem::class);
    }

    // todo: check is this relationship possible
    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
}
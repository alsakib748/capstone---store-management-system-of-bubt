<?php

namespace App\Models;

use App\Models\Issue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class IssueItem extends Model
{

    protected $guarded = [];

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
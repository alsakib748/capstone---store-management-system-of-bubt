<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueReturnItem extends Model
{
    protected $guarded = [];

    public function issueReturn()
    {
        return $this->belongsTo(IssueReturn::class, 'issue_return_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function issueItem()
    {
        return $this->belongsTo(IssueItem::class, 'issue_item_id');
    }
}
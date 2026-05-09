<?php

namespace App\Models;

use App\Models\IssueItem;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{

    protected $guarded = [];

    public function issueItems()
    {
        return $this->hasMany(IssueItem::class);
    }

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issuedByUser()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

}

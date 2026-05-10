<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueReturn extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function issueReturnItems()
    {
        return $this->hasMany(IssueReturnItem::class);
    }
}
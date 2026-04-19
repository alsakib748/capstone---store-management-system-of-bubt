<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ReturnPurchase extends Model
{
    protected $guarded = [];

    public function purchaseItems()
    {
        return $this->hasMany(ReturnPurchaseItem::class, 'return_purchase_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class, 'warehouse_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'return_purchase_roles');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }


}

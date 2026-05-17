<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Product extends Model
{
    protected $guarded = [];

    /**
     * Build a fixed SKU from category, subcategory, brand, product name, and id.
     */
    public static function generateSKU(string $category, string $subcategory, string $brand, string $productName, int $id): string
    {
        $cat = strtoupper(substr($category, 0, 2));
        $sub = strtoupper(substr($subcategory, 0, 2));
        $br = strtoupper(substr($brand, 0, 2));

        $words = explode(' ', trim($productName));
        $prod = '';
        foreach ($words as $w) {
            if ($w !== '') {
                $prod .= strtoupper(substr($w, 0, 1));
            }
        }

        return "{$cat}-{$sub}-{$br}-{$prod}-" . str_pad((string) $id, 3, '0', STR_PAD_LEFT);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function allowedRoles()
    {
        return $this->belongsToMany(Role::class, 'product_role_permissions')->withTimestamps();
    }

}
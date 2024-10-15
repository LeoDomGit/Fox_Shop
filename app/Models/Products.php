<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'id',
        'name',
        'slug',
        'attribute',
        'price',
        'compare_price',
        'discount',
        'color',
        'content',
        'id_brand',
        'in_stock',
        'created_at',
        'updated_at',
    ];
    // public function categories()
    // {
    //     return $this->belongsTo(Categories::class, 'idCate');
    // }

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'id_parent');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'product_categories', 'id_product', 'id_categories');
    }
}

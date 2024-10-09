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
        'content',
        'id_brand',
        'created_at',
        'updated_at',
    ];
}

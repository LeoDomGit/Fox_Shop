<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table='product_categories';
    protected $fillable=['id','id_product','id_categories','created_at','updated_at'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAddData extends Model
{
    use HasFactory;
    public $table = 'products_add_data';
    protected $fillable = ['category_id', 'size', 'product_id', 'subcategory_id', 'subcategory_val', 'flange_val', 'flange_percentage', 'footval', 'typeOption'];
}

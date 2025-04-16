<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_product',
        'stock',
        'price',
        'image',
    ];
    public function detail_sales() {
        return $this->hasMany(Detail_sale::class);
    }
    
}

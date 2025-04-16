<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_sale extends Model
{
    use HasFactory;

    protected  $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'sub_total'
    ];

    public function products(){
        return $this->belongsTo(ProductController::class, 'product_id');
    }

    public function sales(){
        return $this->belongsTo(SaleController::class, 'sale_id');
    }
}

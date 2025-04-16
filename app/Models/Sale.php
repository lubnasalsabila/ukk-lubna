<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'sale_date',
        'customer_id',
        'total_price',
        'total_pay',
        'cashback',
        'earn_poin',
        'used_poin',
        'staff_id',
    ];

    public function detail_sales(){
        return $this->hasMany(DetailSale::class, 'sale_id');
    }

    public function customers() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function users() {
        return $this->belongsTo(User::class, 'staff_id');
    }
}

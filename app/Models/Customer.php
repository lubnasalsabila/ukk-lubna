<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'no_telp',
        'poin',
    ];

    public function sales() {
        return $this->hasMany(Sale::class);
    }

}

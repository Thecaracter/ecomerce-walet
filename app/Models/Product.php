<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';


    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'foto',
        'berat',
        'is_active',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}

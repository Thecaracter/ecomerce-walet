<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_detail';
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
    ];

    /**
     * Get the order that owns the order detail.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that is associated with the order detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

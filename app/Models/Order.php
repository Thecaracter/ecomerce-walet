<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable = [
        'order_number',
        'user_id',
        'total_price',
        'total_weight',
        'status',
        'alamat_pengiriman',
        'pengiriman',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order details for the order.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}

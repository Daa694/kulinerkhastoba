<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'kuliner_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class);
    }

    // Helper Methods
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}

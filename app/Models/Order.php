<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'status',
        'payment_status',
        'snap_token',
        'order_id'
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

    protected $attributes = [
        'status' => 'pending',
        'payment_status' => 'pending'
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Payment Status constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_EXPIRED = 'expired';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper Methods
    public function updateTotal()
    {
        $this->total = $this->orderItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $this->save();
    }

    public function generateOrderId()
    {
        return 'ORDER-' . time() . '-' . $this->id;
    }

    public function getMidtransPaymentInfo()
    {
        return [
            'transaction_details' => [
                'order_id' => $this->order_id,
                'gross_amount' => (int) $this->total
            ],
            'customer_details' => [
                'first_name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone ?? '',
                'billing_address' => [
                    'first_name' => $this->user->name,
                    'phone' => $this->user->phone ?? '',
                    'address' => $this->user->alamat ?? ''
                ]
            ],
            'item_details' => $this->orderItems->map(function ($item) {
                return [
                    'id' => $item->kuliner_id,
                    'price' => (int) $item->price,
                    'quantity' => $item->quantity,
                    'name' => $item->kuliner->nama
                ];
            })->toArray()
        ];
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isProcessing()
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isPaid()
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function markAsPaid()
    {
        $this->payment_status = self::PAYMENT_PAID;
        $this->status = self::STATUS_PROCESSING;
        $this->save();
    }
}

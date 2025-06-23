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
    const STATUS_DIANTAR = 'diantar';
    const STATUS_SUKSES = 'sukses';
    const STATUS_BATAL = 'batal';    // Payment Status constants from Midtrans
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_SUCCESS = 'success';
    const PAYMENT_SETTLEMENT = 'settlement';
    const PAYMENT_CAPTURE = 'capture';
    const PAYMENT_CHALLENGE = 'challenge';
    const PAYMENT_DENY = 'deny';
    const PAYMENT_CANCEL = 'cancel';
    const PAYMENT_EXPIRE = 'expire';
    const PAYMENT_FAILURE = 'failure';
    const PAYMENT_REFUND = 'refund';
    const PAYMENT_CHARGEBACK = 'chargeback';
    const PAYMENT_PARTIAL_REFUND = 'partial_refund';
    const PAYMENT_PARTIAL_CHARGEBACK = 'partial_chargeback';
    const PAYMENT_AUTHORIZE = 'authorize';
    const PAYMENT_GAGAL = 'gagal';

    // Helper method to get payment status display text
    public function getPaymentStatusText()
    {
        return match($this->payment_status) {
            self::PAYMENT_SETTLEMENT, 
            self::PAYMENT_CAPTURE, 
            self::PAYMENT_SUCCESS => 'Pembayaran Berhasil',
            self::PAYMENT_PENDING => 'Menunggu Pembayaran',
            self::PAYMENT_CHALLENGE => 'Pembayaran Ditantang',
            self::PAYMENT_DENY => 'Pembayaran Ditolak',
            self::PAYMENT_CANCEL => 'Pembayaran Dibatalkan',
            self::PAYMENT_EXPIRE => 'Pembayaran Kadaluarsa',
            self::PAYMENT_FAILURE,
            self::PAYMENT_GAGAL => 'Pembayaran Gagal',
            self::PAYMENT_REFUND => 'Dana Dikembalikan',
            self::PAYMENT_CHARGEBACK => 'Chargeback',
            self::PAYMENT_PARTIAL_REFUND => 'Pengembalian Dana Sebagian',
            self::PAYMENT_PARTIAL_CHARGEBACK => 'Chargeback Sebagian',
            self::PAYMENT_AUTHORIZE => 'Pembayaran Diotorisasi',
            default => 'Status Tidak Dikenal'
        };
    }

    // Helper method to get payment status color class
    public function getPaymentStatusColorClass()
    {
        return match($this->payment_status) {
            self::PAYMENT_SETTLEMENT,
            self::PAYMENT_CAPTURE,
            self::PAYMENT_SUCCESS => 'bg-green-100 text-green-800',
            self::PAYMENT_PENDING,
            self::PAYMENT_AUTHORIZE => 'bg-yellow-100 text-yellow-800',
            self::PAYMENT_CHALLENGE => 'bg-orange-100 text-orange-800',
            self::PAYMENT_DENY,
            self::PAYMENT_CANCEL,
            self::PAYMENT_EXPIRE,
            self::PAYMENT_FAILURE,
            self::PAYMENT_GAGAL => 'bg-red-100 text-red-800',
            self::PAYMENT_REFUND,
            self::PAYMENT_CHARGEBACK,
            self::PAYMENT_PARTIAL_REFUND,
            self::PAYMENT_PARTIAL_CHARGEBACK => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Helper method to check if payment is successful
    public function isPaymentSuccess()
    {
        return in_array($this->payment_status, [
            self::PAYMENT_SETTLEMENT,
            self::PAYMENT_CAPTURE,
            self::PAYMENT_SUCCESS
        ]);
    }

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

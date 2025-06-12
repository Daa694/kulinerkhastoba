<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'kuliner_id',
        'quantity',
        'is_checked_out'
    ];

    protected $casts = [
        'is_checked_out' => 'boolean',
        'quantity' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class);
    }

    // Helper Methods
    public function getSubtotalAttribute()
    {
        return $this->kuliner->harga * $this->quantity;
    }

    public static function getCartTotal($userId)
    {
        return self::where('user_id', $userId)
            ->where('is_checked_out', false)
            ->with('kuliner')
            ->get()
            ->sum(function($item) {
                return $item->kuliner->harga * $item->quantity;
            });
    }

    public static function getUserCart($userId)
    {
        return self::where('user_id', $userId)
            ->with('kuliner')
            ->get();
    }

    // Global Scope for active cart items
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('active', function ($builder) {
            $builder->where('is_checked_out', false);
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuliner extends Model
{
    use HasFactory;

    protected $table = 'kuliners';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'gambar',
        'stok',
        'tersedia'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'tersedia' => 'boolean'
    ];

    // Relationships
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('tersedia', true)->where('stok', '>', 0);
    }

    public function scopePopular($query)
    {
        return $query->withAvg('ratings', 'rating')
                    ->orderByDesc('ratings_avg_rating');
    }

    // Accessors & Mutators
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Helper Methods
    public function updateStok($quantity)
    {
        $this->stok -= $quantity;
        if ($this->stok <= 0) {
            $this->tersedia = false;
        }
        $this->save();
    }

    public function restoreStok($quantity)
    {
        $this->stok += $quantity;
        if ($this->stok > 0) {
            $this->tersedia = true;
        }
        $this->save();
    }

    public function hasStock($quantity = 1)
    {
        return $this->tersedia && $this->stok >= $quantity;
    }

    public function getAverageRating()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [
        'user_id', 'kuliner_id', 'jumlah', 'is_checked_out'
    ];

    public function kuliner()
    {
        return $this->belongsTo(Kuliner::class);
    }
}

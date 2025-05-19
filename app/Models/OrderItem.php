<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'type',
        'img_url'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

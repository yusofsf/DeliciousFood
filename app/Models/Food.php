<?php

namespace App\Models;

use Binafy\LaravelCart\Cartable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Food extends Model implements Cartable
{
    protected $fillable = [
        'name',
        'ingredients',
        'img_url',
        'price',
        'type'
    ];
    protected $table = 'foods';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPrice(): float
    {
        return (float)$this->price;
    }
}

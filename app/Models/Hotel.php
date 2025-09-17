<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'country',
        'description',
        'price_per_night',
        'image',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
    ];

    protected $attributes = [
        'price_per_night' => 0.00,
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }
}
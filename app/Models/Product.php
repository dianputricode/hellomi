<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'price',
        'product_image',
        'material',
        'weight',
        'capacity',
        'dimensions',
        'stock',
    ];

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function rate()
    {
        return $this->hasMany(Rate::class);
    }

    public function getAverageRatingAttribute()
    {
        $totalRating = $this->rate()->sum('rating');
        $numberOfRatings = $this->rate()->count();

        if ($numberOfRatings > 0) {
            return round($totalRating / $numberOfRatings, 1);
        } else {
            return 0;
        }
    }
}

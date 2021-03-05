<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ame extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'street', 'city', 'state', 'zip', 'phone'
    ];

    public function getAverageRatingAttribute()
    {
        return $this->reviews->pluck('rating')->average();
    }

    public function reviews()
    {
        return $this->hasMany(AmeReview::class);
    }
}

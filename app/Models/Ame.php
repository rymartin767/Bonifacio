<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ame extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'street', 'city', 'state', 'zip', 'phone', 'rating'
    ];

    protected $casts = [
        'rating' => 'decimal:1'
    ];

    protected $withCount = ['comments'];

    // public function getPhoneAttribute($value)
    // {
    //     $subOne = substr($value, 0, 3);
    //     $subTwo = substr($value, 3, 3);
    //     $subThree = substr($value, 6, 4);

    //     return $subOne . '-' . $subTwo . '-' . $subThree;

    // }

    public function comments()
    {
        return $this->hasMany(AmeComment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmeReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id', 'comment', 'rating'
    ];

    protected static function booted()
    {
        static::created(function ($review) {
            $ame = $review->ame;
            $average = $ame->reviews->pluck('rating')->average();
            $ame->rating = $average;
            $ame->save();
        });
    }

    public function ame()
    {
        return $this->belongsTo(Ame::class);
    }
}

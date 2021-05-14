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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    
}

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

    public function ame()
    {
        return $this->belongsTo(Ame::class);
    }
}

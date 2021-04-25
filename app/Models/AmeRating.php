<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmeRating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'rating'];

    public function Ame()
    {
        return $this->belongsTo(Ame::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AmeComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'body'
    ];

    protected static function booted()
    {
        static::created(function ($comment) {
            $ame = $comment->ame;
            $ame->updated_at = Carbon::now();
            $ame->save();
        });
    }

    public function ame()
    {
        return $this->belongsTo(Ame::class);
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_name', 'user_employee_number', 'body'];

    protected static function booted()
    {
        static::created(function ($comment) {
            $type = $comment->commentable_type;
            $model = $type::find($comment->commentable_id);
            $model->updated_at = Carbon::now();
            $model->save();
        });
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}

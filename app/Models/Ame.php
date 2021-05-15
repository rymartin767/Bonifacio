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

    public function scopeState($query, $state)
    {
        $query->when($state, function ($query, $state) {
            return $query
                ->where('state', $state);
        }, function ($query) {
            return $query;
        });
    }

    public function scopeSearch($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query
                ->where('name', 'like', '%' . $search . '%');
        }, function ($query) {
            return $query;
        });
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    
}

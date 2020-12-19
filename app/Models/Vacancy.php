<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_seniority', 'emp', 'base', 'fleet', 'seat', 'award_base', 'award_fleet', 'award_seat', 'month'
    ];

    protected $casts = [ 
        'month' => 'date:M Y'
    ];
}

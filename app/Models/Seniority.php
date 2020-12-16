<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seniority extends Model
{
    use HasFactory;

    protected $fillable = [
        'sen', 'phire', 'emp', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'active', 'month'
    ];

    protected $casts = [ 
        'month' => 'date:M Y'
    ];
}
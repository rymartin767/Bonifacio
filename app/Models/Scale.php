<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scale extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'fleet', 'ca', 'fo'];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }
}
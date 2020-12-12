<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Actions\Airlines\SeedScales;

class Airline extends Model
{
    use HasFactory;
    use SeedScales;

    protected $fillable = [
        'sector', 'name', 'icao', 'iata', 'union', 'pilots', 'hiring', 'url'
    ];

    protected $casts = [
        'hiring' => 'boolean'
    ];

    public static function atlas()
    {
        return Airline::where('icao', 'GTI')->first();
    }
    
    public function path($append = '')
    {
        $path = "/airlines/$this->icao";
        return $append ? "{$path}/{$append}" : $path;
    }

    public function scales()
    {
        return $this->hasMany(Scale::class);
    }
}
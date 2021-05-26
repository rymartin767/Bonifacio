<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_seniority', 'emp', 'base', 'fleet', 'seat', 'award_base', 'award_fleet', 'award_seat', 'upgrade', 'new_hire', 'month'
    ];

    protected $casts = [ 
        'month' => 'date:M Y'
    ];

    public function scopeUpgrades($query, $fleet)
    {
        if($fleet) {
            return $query->where('upgrades', true)->groupBy('award_fleet');
        }

        return $query->where('upgrades', true)->sortyBy('emp');
    }
}

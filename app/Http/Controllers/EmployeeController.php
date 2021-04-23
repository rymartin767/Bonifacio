<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Seniority;
use App\Models\Airline;
use App\Models\Vacancy;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function __invoke()
    {
        if (request('number')) {
        
            $collection = collect();
            
            // Current + Award Stats
            $award = Vacancy::where('emp', request('number'))->get()->first();
        
            if ($award) {
                // Current
                $collection->put('current', [
                    'base' => $award->base,
                    'seat' => $award->seat,
                    'fleet' => $award->fleet
                ]);
                // Award
                $collection->put('award', [
                    'award_base' =>  $award->award_base,
                    'award_seat' =>  $award->award_seat,
                    'award_fleet' =>  $award->award_fleet,
                    'upgrade' =>  $award->upgrade
                ]);
            }
    
            // Seniority History
            $months = Seniority::select(['sen', 'emp', 'doh', 'retire', 'seat', 'fleet', 'domicile', 'month'])->where('emp', request('number'))->get()->sortBy('month');
            if ($months) {
                $service_in_months = date_diff(Carbon::now(), Carbon::create($months->first()->doh))->format('%y YRS + %m MOS');
                $service_in_years = Carbon::now()->diffInYears($months->first()->doh) + 1;
                $collection->put('history', [
                    'doh' => $months->first()->doh,
                    'months' => $months,
                    'retire' => $months->first()->retire,
                    'service_in_years' => $service_in_years,
                    'service_in_months' => $service_in_months
                ]);
            }
    
            // Compensation
            $scales = Airline::atlas()->scales->where('fleet', $award['fleet'])->pluck(Str::of($award['seat'])->lower());
            if ($scales) {
                // Employee Rate
                $doh = Seniority::where('emp', request('number'))->first()->doh;
                $years = Carbon::now()->diffInYears($doh);
                $rate = $scales[$years];
    
                // Guarantee
                $hours = $years > 0 ? 62 : 50;
                $salary = number_format(($hours*intval($rate)), 2);
    
                // Return
                $collection->put('compensation', [
                    'rates' => $scales,
                    'rate' => $rate,
                    'guarantee_hours' => $hours,
                    'guarantee_salary' => $salary
                ]);
            }
    
            if($collection->isNotEmpty()) {
                return response()->json(['data' => $collection], 200);
            }
    
            return response()->json(['data' => []], 404);
        }
    }
}

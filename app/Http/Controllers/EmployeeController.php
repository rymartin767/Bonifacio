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
                $collection->put('currentPosition', [
                    'base' => $award->base,
                    'seat' => $award->seat,
                    'fleet' => $award->fleet
                ]);
                // Award
                $collection->put('awardPosition', [
                    'base' =>  $award->award_base,
                    'seat' =>  $award->award_seat,
                    'fleet' =>  $award->award_fleet,
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
                    'serviceInYears' => $service_in_years,
                    'serviceInMonths' => $service_in_months
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
                    'guaranteeHours' => $hours,
                    'guaranteeSalary' => $salary
                ]);
            }
    
            if($collection->isNotEmpty()) {
                return response()->json(['data' => $collection], 200);
            }
    
            return response()->json(['data' => []], 404);
        }
    }
}

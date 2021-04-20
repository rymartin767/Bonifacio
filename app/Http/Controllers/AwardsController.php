<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Seniority;
use App\Models\Airline;
use App\Models\Vacancy;
use Carbon\Carbon;

class AwardsController extends Controller
{
    public function __invoke()
    {
        if (request('employee')) {
            $collection = collect();

            // Current + Award Stats
            $award = Vacancy::where('emp', request('employee'))->sole();
            if ($award) {
                $collection->put('base_seniority', $award->base_seniority);
                $collection->put('base', $award->base);
                $collection->put('seat', $award->seat);
                $collection->put('fleet', $award->fleet);
                $collection->put('award_base', $award->award_base);
                $collection->put('award_seat', $award->award_seat);
                $collection->put('award_fleet', $award->award_fleet);
                $collection->put('upgrade', $award->upgrade);
            }

            // Seniority History
            $history = Seniority::select(['sen', 'emp', 'doh', 'retire', 'seat', 'fleet', 'domicile', 'month'])->where('emp', request('employee'))->get()->sortBy('month');
            if ($history) {
                $collection->put('history', $history);
                $collection->put('doh', $history->first()->doh);
                $collection->put('retire', $history->first()->retire);
            }

            // Fleet Rates
            $scales = Airline::atlas()->scales->where('fleet', $award['fleet'])->pluck(Str::of($award['seat'])->lower());
            if ($scales) {
                $collection->put('rates', $scales);

                // Employee Rate
                $doh = Seniority::where('emp', request('employee'))->first()->doh;
                $years = Carbon::now()->diffInYears($doh);
                $rate = $scales[$years];
                $collection->put('rate', $rate);

                // Guarantee
                $hours = $years > 0 ? 62 : 50;
                $collection->put('guarantee_hours', $hours);
                $collection->put('guarantee_salary', number_format($hours*intval($rate)), 2);
            }

            if($collection->isNotEmpty()) {
                return response()->json(['data' => $collection], 200);
            }

            return response()->json(['data' => []], 404);
        }

        return response()->json(['data' => []], 404);
    }
}

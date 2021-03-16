<?php

namespace App\Http\Controllers;

use App\Models\Seniority;

class MonthlyStaffingChartController extends Controller
{
    public function show()
    {
        $months = Seniority::pluck('month')->unique()->sort()->take(-12);

        if($months) {
            $collection = collect([]);
            foreach($months as $month)
            {
                $collection->put($month->format('M Y'), Seniority::where('month', $month->format('Y-m-d'))->count());
            }

            return response()->json(['data' => $collection], 200);
        }
        
        return response()->json(['data' => []], 404);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Seniority;

class MonthlyStaffingChartController extends Controller
{
    public function show()
    {
        $months = Seniority::pluck('month')->unique()->sort();
        if($months) {
            $collection = collect([]);
            foreach($months as $month)
            {
                $collection->put($month->format('M Y'), Seniority::where('month', $month->format('Y-m-d'))->count());
            }

            return response()->json([
                'status' => 201,
                'data' => $collection
            ]);
        }
        
        return response()->json([
            'status' => 404
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Seniority;
use Carbon\Carbon;
use Exception;

class RetirementChartController extends Controller
{
    public function __invoke()
    {
        $month = Seniority::pluck('month')->unique()->sort()->last();
        $current_list = Seniority::where('month', $month)->get();

        try {
            $collection = $current_list->groupBy(function ($item, $key) {
                return Carbon::parse($item['retire'])->format('Y');
            })->map->count()->sortKeys();
            
            return response()->json(['data' => $collection->all()], 200);
        } catch(Exception $e) {
            return response()->json(['data' => []], 404);
        }
    }
}

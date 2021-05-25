<?php

namespace App\Http\Controllers;

use App\Models\Seniority;
use Carbon\Carbon;
use Exception;

class SeniorityController extends Controller
{
    public function index()
    {
        request('month') ?
            $list = Seniority::where('month', request('month'))->get() :
            $list = Seniority::where('month', Seniority::pluck('month')->unique()->sort()->last())->get();
        
        if($list->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'data' => $list
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
    }

    public function show()
    {
        if(request('year')) {
            $begin = Carbon::create(request('year'))->startOfYear();
            $end = Carbon::create(request('year'))->endOfYear();
        } else {
            $begin = Carbon::today()->startOfYear();
            $end = Carbon::today()->endOfYear();
        }

        request('employee') ?
            $months = Seniority::select(['sen', 'phire', 'emp', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'month'])
                ->where('emp', request('employee'))
                ->whereBetween('month', [$begin, $end])
                ->get()->sortBy('month') :
            $months = collect();
        
        if($months->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'data' => $months
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
    }

    public function breakdown()
    {
        try {
            $months = Seniority::pluck('month')->unique()->sort()->take(2);

            $latest_list = Seniority::where('month', $months->last())->get();
            $previous_list_count = Seniority::where('month', $months->first())->count();
            $january_list_count = Seniority::where('month', 'JAN 2021')->count();

            $ages = collect();
            foreach($latest_list as $pilot) {
                $years_to_go = now()->diffInYears($pilot->retire) + 1;
                $ages->push(65-$years_to_go);
            }

            $breakdown = collect([
                "List Month" => $latest_list->last()->month,
                "Total" => $latest_list->count(),
                "Active" => $latest_list->where('active', true)->count(),
                "Inactive" => $latest_list->where('active', false)->count(),
                "Net Gain" => $latest_list->count() - $previous_list_count,
                "Annual Gain" => $latest_list->count() - $january_list_count,
                "Average Age" => $ages->average()
            ]);

            return response()->json(['data' => $breakdown], 200);
        } catch (Exception $e) {
            return response()->json(['data' => collect([
                'errors' => $e->getMessage()
            ])], 200);
        }
    }
}

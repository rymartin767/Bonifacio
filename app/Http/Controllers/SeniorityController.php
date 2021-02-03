<?php

namespace App\Http\Controllers;

use App\Models\Seniority;
use Carbon\Carbon;

class SeniorityController extends Controller
{
    public function index()
    {
        request('month') ?
            $list = Seniority::where('month', request('month'))->get() :
            $list = Seniority::where('month', Seniority::pluck('month')->unique()->sort()->last())->get();
        
        if($list->isNotEmpty()) {
            return response()->json([
                'status' => 201,
                'data' => $list
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
    }

    public function show()
    {
        $begin = Carbon::create(request('year'))->startOfYear();
        $end = Carbon::create(request('year'))->endOfYear();

        request('employee') ?
            $months = Seniority::select(['sen', 'phire', 'emp', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'month'])
                ->where('emp', request('employee'))
                ->whereBetween('month', [$begin, $end])
                ->get()->sortBy('month') :
            $months = collect();
        
        if($months->isNotEmpty()) {
            return response()->json([
                'status' => 201,
                'data' => $months
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
    }
}

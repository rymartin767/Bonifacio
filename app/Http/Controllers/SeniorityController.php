<?php

namespace App\Http\Controllers;

use App\Models\Seniority;

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
        request('employee') ?
            $months = Seniority::select(['sen', 'phire', 'emp', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'month'])
                ->where('emp', request('employee'))
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

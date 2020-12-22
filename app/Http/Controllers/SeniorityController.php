<?php

namespace App\Http\Controllers;

use App\Models\Seniority;

class SeniorityController extends Controller
{
    public function index()
    {
        if(request('month')) {
            $pilots = Seniority::select(['sen', 'phire', 'emp', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'month'])
                ->where('month', request('month'))
                ->get()->sortBy('month');
        } else {
            $pilots = Seniority::select(['sen', 'phire', 'emp', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'month'])->get()->sortBy('month');
        }
        
        if($pilots) {
            return response()->json([
                'status' => 201,
                'data' => $pilots
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
        
    }

    public function show()
    {
        if(request('employee')) {
            $pilot = Seniority::select(['sen', 'phire', 'emp', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'month'])
                ->where('emp', request('employee'))
                ->get()->sortBy('month');
        }

        if($pilot) {
            return response()->json([
                'status' => 201,
                'data' => $pilot
            ]);
        }

        return response()->json([
            'status' => 404
        ]);
    }
}

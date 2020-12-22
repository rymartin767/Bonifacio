<?php

namespace App\Http\Controllers;

use App\Models\Seniority;

class SeniorityController extends Controller
{
    public function show()
    {
        if(request('employee')) {
            $months = Seniority::select(['sen', 'phire', 'emp', 'doh', 'seat', 'fleet', 'domicile', 'retire', 'month'])
                ->where('emp', request('employee'))
                ->get()->sortBy('month');
        }

        if($months) {
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

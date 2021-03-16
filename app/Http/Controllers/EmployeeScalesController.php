<?php

namespace App\Http\Controllers;

use App\Models\Airline;

class EmployeeScalesController extends Controller
{
    public function index()
    {
        $scales = Airline::atlas()->scales;

        if($scales) {
            $rates = $scales->where('fleet', request('fleet'))->pluck(request('seat'));
            if($rates) {
                return response()->json(['data' => $rates], 200);
            }
        }

        return response()->json(['data' => []], 404);
        
    }

    public function show()
    {
        $atlas = Airline::atlas()->scales;

        if($atlas) {
            $scales = $atlas->where('year', request('year'))->where('fleet', request('fleet'))->first();
                if($scales) {
                    $seat = request('seat');
                    $rate = $scales[$seat];
                    return response()->json(['data' => $rate], 200);
                }
        }

        return response()->json(['data' => []], 404);
        
    }
}

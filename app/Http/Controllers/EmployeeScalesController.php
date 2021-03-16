<?php

namespace App\Http\Controllers;

use App\Models\Airline;

class EmployeeScalesController extends Controller
{
    public function index()
    {
        $atlas = Airline::atlas()->scales;

        if($atlas) {
            $scales = $atlas->select(['fleet', request('seat')])->where('fleet', request('fleet'))->pluck(request('seat'));
            if($scales) {
                return response()->json(['data' => $scales], 200);
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

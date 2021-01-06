<?php

namespace App\Http\Controllers;

use App\Models\Airline;

class EmployeeScalesController extends Controller
{
    public function index()
    {
        $scales = Airline::atlas()->scales;

        if($scales) {
            if(request('fleet') && request('seat')) {
                $scales = Airline::atlas()->scales()->select(['year', 'fleet', request('seat')])->where('fleet', request('fleet'))->get();
                return response()->json([
                    'status' => 201,
                    'data' => $scales
                ]);
            }
        }

        return response()->json([
            'status' => 404
        ]);
        
    }

    public function show()
    {
        $scales = Airline::atlas()->scales;

        if($scales) {
            if(request('year') && request('fleet') && request('seat')) {
                $scales = $scales->where('year', request('year'))->where('fleet', request('fleet'))->first();
                $seat = request('seat');
                $rate = $scales[$seat];
                return response()->json([
                    'status' => 201,
                    'data' => $rate
                ]);
            }
        }

        return response()->json([
            'status' => 404
        ]);
        
    }
}

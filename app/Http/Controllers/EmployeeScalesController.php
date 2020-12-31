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
                $scales = $scales->where('fleet', request('fleet')->where('seat', request('seat')));
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
                $scales = $scales->where('year', request('year'))->where('fleet', request('fleet'))->where('seat', request('seat'))->get();
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
}

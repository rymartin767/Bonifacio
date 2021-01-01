<?php

namespace App\Http\Controllers;

use App\Models\Airline;

class ScaleController extends Controller
{
    public function show()
    {
        if(request('airline')) {
            $airline = Airline::where('icao', request('airline'))->first();
            if($airline) {
                return response()->json([
                    'status' => 201,
                    'data' => $airline->scales
                ]);
            }
        }

        return response()->json([
            'status' => 404
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Airline;

class AtlasPayRatesController extends Controller
{
    public function __invoke()
    {
        $airline = Airline::atlas()->load('scales');
        if($airline) {
            return response()->json(['data' => $airline->scales], 200);
        }

        return response()->json(['data' => []], 404);
    }
}

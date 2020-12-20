<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class ScaleController extends Controller
{
    public function show(Airline $airline)
    {
        return response()->json([
            'status' => 200,
            'data' => $airline->scales
        ]);
    }
}

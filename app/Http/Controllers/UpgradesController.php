<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class UpgradesController extends Controller
{
    public function index()
    {
        $upgrades = Vacancy::where('upgrade', 1)->get()->groupBy('award_fleet');

        if($upgrades->isNotEmpty()) {
            return response()->json(['data' => $upgrades], 200);
        }
    
        return response()->json([
            'status' => 404
        ]);
    }
}

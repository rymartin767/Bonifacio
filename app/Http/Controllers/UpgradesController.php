<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class UpgradesController extends Controller
{
    public function index()
    {
        $upgrades = Vacancy::where('upgrade', 1)->groupBy('award_fleet');

        if($upgrades->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'data' => $upgrades
            ]);
        }
    
        return response()->json([
            'status' => 404
        ]);
    }
}

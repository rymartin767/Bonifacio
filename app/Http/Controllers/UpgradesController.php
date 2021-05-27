<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class UpgradesController extends Controller
{
    public function index()
    {
        $upgrades = request('groupByFleet') ? Vacancy::upgrades()->get()->groupBy('award_fleet') : Vacancy::upgrades()->get()->sortBy('emp');
        return response()->json(['data' => $upgrades], 200);
    }
}

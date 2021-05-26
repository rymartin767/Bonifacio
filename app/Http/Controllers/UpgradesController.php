<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class UpgradesController extends Controller
{
    public function index()
    {
        $upgrades = Vacancy::upgrades(request('fleet'))->get();
        return response()->json(['data' => $upgrades], 200);
    }
}

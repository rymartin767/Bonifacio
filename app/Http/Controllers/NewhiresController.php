<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class NewhiresController extends Controller
{
    public function index()
    {
        $newhires = Vacancy::where('new_hire', true)->get()->groupBy(['award_fleet', 'award_base']);
        return response()->json(['data' => $newhires], 200);
    }
}

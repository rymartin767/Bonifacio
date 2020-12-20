<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class VacancyController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 200,
            'data' => Vacancy::all()
        ]);
    }

    public function show()
    {
        $award = Vacancy::where('emp', request('employee'))->first();
        if($award) {
            return response()->json([
                'status' => 200,
                'data' => $award
            ]);
        }

        return response()->json([
            'status' => 403
        ]);
    }
}

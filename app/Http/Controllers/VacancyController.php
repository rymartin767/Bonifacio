<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::all();

        if($vacancies) {
            return response()->json(['data' => $vacancies], 200);
        }

        return response()->json(['data' => []], 404);
    }

    public function show()
    {
        $award = Vacancy::where('emp', request('employee'))->sole();
        if($award) {
            return response()->json(['data' => $award], 200);
        }

        return response()->json(['data' => []], 404);
    }
}

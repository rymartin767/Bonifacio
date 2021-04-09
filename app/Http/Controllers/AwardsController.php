<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;

class AwardsController extends Controller
{
    public function __invoke()
    {
        if (request('employee')) {
            $award = Vacancy::where('emp', request('employee'))->sole();

            if ($award) {
                return response()->json(['data' => $award], 200);
            }

            return response()->json(['data' => []], 404);
        }

        $vacancies = Vacancy::all();

        if($vacancies) {
            return response()->json(['data' => $vacancies], 200);
        }

        return response()->json(['data' => []], 404);
    }
}

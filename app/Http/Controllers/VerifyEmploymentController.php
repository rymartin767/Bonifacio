<?php

namespace App\Http\Controllers;

use App\Models\Seniority;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VerifyEmploymentController extends Controller
{
    public function show()
    {
        $month = Seniority::pluck('month')->unique()->sort()->last();

        try {
            $pilot = Seniority::where('month', $month)->where('emp', request('employee'))->where('sen', request('sen'))->sole();
            return response()->json(['data' => $pilot], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['data' => []], 404);
        }
    }
}

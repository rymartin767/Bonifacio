<?php

namespace App\Http\Controllers;

use App\Models\Seniority;

class VerifyEmploymentController extends Controller
{
    public function __invoke()
    {
        $month = Seniority::pluck('month')->unique()->sort()->last();
        $pilot = Seniority::where('month', $month)->where('emp', request('employee'))->where('sen', request('sen'));

        if(!$pilot->exists()) {
            return response()->json(['data' => []], 404);
        }

        return response()->json(['data' => $pilot->sole()], 200);    
    }
}

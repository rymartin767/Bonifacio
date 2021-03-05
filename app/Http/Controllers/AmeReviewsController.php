<?php

namespace App\Http\Controllers;

use App\Models\Ame;

class AmeReviewsController extends Controller
{
    public function index()
    {
        if(request('ame')) {
            $ame = Ame::find(request('ame'));
            $reviews = $ame->reviews;

            return response()->json(['data' => $reviews], 200);
        }

        return response()->json(['data' => ['Could not find AME.']], 404);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Ame;

class AmeReviewsController extends Controller
{
    public function index()
    {
        $ame = Ame::find(request('ame'));
        if($ame) {
            $reviews = $ame->reviews;
            return response()->json(['data' => $reviews], 200);
        }

        return response()->json(['data' => []], 404);
    }
}

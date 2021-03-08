<?php

namespace App\Http\Controllers;

use App\Models\Ame;
use Exception;

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

    public function store()
    {
        $ame = Ame::find(request('ame'));
        if($ame) {
            try {
                $review = $ame->reviews()->create([
                    'rating' => request('rating'),
                    'comment' => request('comment'),
                    'emp_id' => request('reviewer')
                ]);

                return response()->json(['data' => $review], 201);
            } catch (Exception $e) {
                return response()->json(['data' => []], 400); // code 400 is a bad request
            }
        }

        return response()->json(['data' => []], 404);
    }
}

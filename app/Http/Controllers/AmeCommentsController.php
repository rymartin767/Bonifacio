<?php

namespace App\Http\Controllers;

use App\Models\Ame;
use Exception;

class AmeCommentsController extends Controller
{
    public function index()
    {
        $ame = Ame::find(request('ame'));
        if($ame) {
            $comments = $ame->comments;
            return response()->json(['data' => $comments], 200);
        }

        return response()->json(['data' => []], 404);
    }

    public function store()
    {
        $ame = Ame::find(request('ame'));
        if($ame) {
            try {
                $review = $ame->comments()->create([
                    'comment' => request('comment'),
                    'user_id' => request('user')
                ]);

                return response()->json(['data' => $review], 201);
            } catch (Exception) {
                return response()->json(['data' => []], 400); // code 400 is a bad request
            }
        }

        return response()->json(['data' => []], 404);
    }
}

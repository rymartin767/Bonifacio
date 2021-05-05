<?php

namespace App\Http\Controllers;

use App\Models\Ame;
use Illuminate\Validation\ValidationException;

class AmeCommentsController extends Controller
{
    public function store($id)
    {
        try {
            $attributes = request()->validate([
                'user_id' => ['required', 'numeric'],
                'body' => ['required', 'string', 'min:5', 'max:999']
            ]);
        } catch (ValidationException $e) {
            return response()->json(['data' => [$e]], 422);
        }
            
        $ame = Ame::find($id);
        if($ame) {
            $ame->comments()->create($attributes);
            return response()->json(['data' => 'success'], 201);
        }

        return response()->json(['data' => []], 404);
    }
}

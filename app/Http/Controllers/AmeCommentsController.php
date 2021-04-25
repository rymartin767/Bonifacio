<?php

namespace App\Http\Controllers;

use App\Models\Ame;
use Illuminate\Validation\ValidationException;

class AmeCommentsController extends Controller
{
    public function store()
    {
        $ame = Ame::find(request('ame_id'));

        if($ame) {
            try {
                $attributes = request()->validate([
                    'user_id' => ['required', 'numeric'],
                    'body' => ['required', 'string', 'min:5', 'max:999']
                ]);
            } catch (ValidationException) {
                return response()->json(['data' => []], 422);
            }

            $ame->comments()->create($attributes);
            
            return response()->json(['data' => $ame], 201);
        }

        return response()->json(['data' => []], 404);
    }
}

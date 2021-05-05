<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Models\Ame;

class AmeCommentsController extends Controller
{
    public function store($id)
    {
        try {
            $attributes = request()->validate([
                'user_id' => ['required', 'numeric'],
                'body' => ['required', 'string', 'min:5', 'max:999']
            ]);

            $ame = Ame::find($id);
            if($ame) {
                $ame->comments()->create($attributes);
                return response()->json(['data' => ['success']], 201);
            }

            return response()->json(['data' => ['AME Model Not Found!']], 422);

        } catch (ValidationException $e) {
            return response()->json(['data' => [$e->getMessage()]], 422);
        } 
    }
}

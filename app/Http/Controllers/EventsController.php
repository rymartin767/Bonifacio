<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Validation\ValidationException;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return response()->json(['data' => $events], 200);
    }

    public function store()
    {
        try {
            $attributes = request()->validate([
                'user_id' => ['required', 'numeric'],
                'title' => ['required', 'string', 'min:3', 'max:50'],
                'date' => ['required', 'date'],
                'time' => ['present', 'date_format:H:i', 'nullable'],
                'image' => ['present', 'string', 'min:5', 'max:100', 'nullable'],
                'url' => ['present', 'string', 'min:5', 'max:100', 'nullable'],
            ]);

            Event::create($attributes);

            return response()->json(['data' => 'Success'], 201);
        }
        catch (ValidationException $e) {
            return response()->json(['data' => [
                'errors' => $e->getMessage()
            ]], 422);
        }

    }

    public function destroy($id)
    {
        $event = Event::destroy($id);

        if($event) {
            return response()->json(['data' => ['Success!']], 200);
        }

        return response()->json(['data' => [
            'errors' => 'Model Not Found!'
        ]], 404);
    }
}

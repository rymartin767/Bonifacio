<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Exception;

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
                'datetime' => ['required', 'date'],
                'image' => ['string', 'nullable', 'min:5', 'max:100'],
                'url' => ['string', 'nullable', 'min:5', 'max:100'],
            ]);

            Event::create($attributes);

            return response()->json(['data' => 'Success'], 201);
        }
        catch (Exception $e) {
            return response()->json(['data' => [$e->getMessage()]], 422);
        }

    }
}

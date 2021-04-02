<?php

namespace App\Http\Controllers;

use App\Models\Seniority;

class DomicilesController extends Controller
{
    public function index()
    {
        $month = Seniority::pluck('month')->unique()->sort()->last();
        $list = Seniority::select(['domicile', 'fleet', 'month'])->where('month', $month)->get();

        $collection = collect();
        $hubs = ['ANC', 'CVG', 'JFK', 'LAX', 'MIA', 'ONT', 'ORD'];

        foreach($hubs as $hub) {
            $collection->put($hub, [
                'total' => $list->where('domicile', $hub)->count(), 
                '747' => $list->where('domicile', $hub)->where('fleet', '747')->count(),
                '767' => $list->where('domicile', $hub)->where('fleet', '767')->count()
            ])->sortByDesc('total');
        }
        
        return response()->json(['data' => $collection], 200);
    }

    public function show()
    {
        if(request('hub')) {
            $month = Seniority::pluck('month')->unique()->sort()->last();
            $list = Seniority::select(['domicile', 'fleet', 'month'])->where('month', $month)->where('domicile', request('hub'))->get();

            $collection = collect();
            
            $collection->put(request('hub'), [
                'total' => $list->where('domicile', request('hub'))->count(), 
                '747' => $list->where('domicile', request('hub'))->where('fleet', '747')->count(),
                '767' => $list->where('domicile', request('hub'))->where('fleet', '767')->count()
            ])->sortByDesc('total');
            
            return response()->json(['data' => $collection], 200);
        }

        return response()->json([
            'status' => 404
        ]);
    }
}

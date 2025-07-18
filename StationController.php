<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    /**
     * Get stations for a specific region.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStationsByRegion(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
        ]);
        
        $stations = Station::where('region_id', $request->region_id)
            ->select('id', 'name')
            ->get();
        
        return response()->json($stations);
    }
}
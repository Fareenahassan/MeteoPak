<?php

namespace App\Http\Controllers;

use App\Models\WeatherObservation;
use App\Models\Region;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Show the welcome page with latest approved weather observations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get latest approved weather observations (limit to 6 for display)
        $latestReports = WeatherObservation::where('status', 'approved')
            ->with(['user.region']) // Eager load user and their region
            ->latest('updated_at')
            ->limit(6)
            ->get();

        // Get all regions for the filter dropdown
        $regions = Region::orderBy('name')->get();

        return view('welcome', compact('latestReports', 'regions'));
    }

    /**
     * Get filtered weather observations based on user's region.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilteredReports(Request $request)
    {
        $query = WeatherObservation::where('status', 'approved')
            ->with(['user.region']); // Eager load user and their region

        // Apply region filter if specified
        if ($request->has('region') && $request->region !== 'all') {
            $regionName = $request->region;
            
            // Filter by user's region name
            $query->whereHas('user.region', function($q) use ($regionName) {
                $q->where('name', $regionName);
            });
        }

        $reports = $query->latest('updated_at')->limit(6)->get();

        return response()->json([
            'success' => true,
            'reports' => $reports,
            'count' => $reports->count()
        ]);
    }

    /**
     * Get weather observation details for modal.
     *
     * @param  \App\Models\WeatherObservation  $observation
     * @return \Illuminate\Http\JsonResponse
     */
    public function getObservationDetails(WeatherObservation $observation)
    {
        // Only show approved observations
        if ($observation->status !== 'approved') {
            abort(404);
        }

        return response()->json([
            'success' => true,
            'observation' => $observation
        ]);
    }
} 
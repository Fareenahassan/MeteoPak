<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeatherObservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WeatherObservationManagementController extends Controller
{
    /**
     * Display a listing of the weather observations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        
        $observations = WeatherObservation::where('status', $status)
            ->latest()
            ->paginate(10);
            
        $pendingCount = WeatherObservation::where('status', 'pending')->count();
        $approvedCount = WeatherObservation::where('status', 'approved')->count();
        $archivedCount = WeatherObservation::where('status', 'archived')->count();
        $flaggedCount = WeatherObservation::where('status', 'flagged')->count();
        
        return view('admin.weather-observations.index', compact(
            'observations', 
            'status',
            'pendingCount',
            'approvedCount',
            'archivedCount',
            'flaggedCount'
        ));
    }
    
    /**
     * Display the specified weather observation.
     *
     * @param  \App\Models\WeatherObservation  $observation
     * @return \Illuminate\View\View
     */
    public function show(WeatherObservation $observation)
    {
        return view('admin.weather-observations.show', compact('observation'));
    }
    
    /**
     * Update the status of a weather observation to approved.
     *
     * @param  \App\Models\WeatherObservation  $observation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(WeatherObservation $observation)
    {
        $observation->update(['status' => 'approved']);
        
        return redirect()->route('admin.weather-observations.show', $observation)
            ->with('success', 'Weather observation has been approved.');
    }
    
    /**
     * Update the status of a weather observation to archived.
     *
     * @param  \App\Models\WeatherObservation  $observation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function archive(WeatherObservation $observation)
    {
        $observation->update(['status' => 'archived']);
        
        return redirect()->route('admin.weather-observations.show', $observation)
            ->with('success', 'Weather observation has been archived.');
    }
    
    /**
     * Update the status of a weather observation to flagged.
     *
     * @param  \App\Models\WeatherObservation  $observation
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function flag(WeatherObservation $observation, Request $request)
    {
        $validated = $request->validate([
            'flag_reason' => 'required|string|max:500'
        ]);
        
        $observation->update([
            'status' => 'flagged',
            'flag_reason' => $validated['flag_reason']
        ]);
        
        return redirect()->route('admin.weather-observations.show', $observation)
            ->with('success', 'Weather observation has been flagged.');
    }
}

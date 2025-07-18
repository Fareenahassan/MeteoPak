<?php

namespace App\Http\Controllers;

use App\Models\WeatherObservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WeatherObservationController extends Controller
{
    public function create()
    {
        return view('user.weather-observations.weather-observation-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location_city' => 'required|string',
            'location_state' => 'required|string',
            'time_zone' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'weather_types' => 'required|array|min:1',
            'damages' => 'nullable|array', // Made optional - removed required and min:1
            'other_damage_details' => 'nullable|string|required_if:damages,other_damage',
            'event_description' => 'nullable|string',
            'media_files' => 'nullable|array',
            'media_files.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240'
        ]);

        // Handle file uploads
        $mediaFiles = [];
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $path = $file->store('weather-observations/' . Auth::id(), 'public');
                $mediaFiles[] = $path;
            }
        }

        // Process damages data
        $damages = $validated['damages'] ?? []; // Default to empty array if no damages selected
        $otherDamageDetails = $request->input('other_damage_details');
        
        // If "other_damage" is selected, store the details along with the damages
        if (!empty($damages) && in_array('other_damage', $damages) && $otherDamageDetails) {
            $damages = array_merge($damages, ['other_damage_details' => $otherDamageDetails]);
        }
        
        // If no damages selected, set to empty array or you could use null
        if (empty($damages)) {
            $damages = []; // or set to null if you prefer: $damages = null;
        }

        // Create the observation
        $observation = WeatherObservation::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->username,
            'personal_number' => Auth::user()->personal_number,
            'designation' => Auth::user()->designation,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'location_city' => $validated['location_city'],
            'location_state' => $validated['location_state'],
            'time_zone' => $validated['time_zone'],
            'event_date' => $validated['event_date'],
            'event_time' => $validated['event_time'],
            'weather_types' => $validated['weather_types'],
            'damages' => $damages,
            'event_description' => $validated['event_description'],
            'media_files' => $mediaFiles,
            'status' => 'pending' // Set default status to pending
        ]);

        // Handle AJAX requests differently
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Weather observation submitted successfully!',
                'redirect' => route('weather.observations')
            ]);
        }

        // Regular form submission response
        return redirect()->route('weather.observations')
            ->with('success', 'Weather observation submitted successfully!');
    }

    public function index()
    {
        $observations = Auth::user()->weatherObservations()->latest()->get();
        return view('user.weather-observations.index', compact('observations'));
    }

    public function show(WeatherObservation $observation)
    {
        // Ensure the observation belongs to the authenticated user
        if ($observation->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to this observation.'
            ], 403);
        }

        // Return the observation details regardless of approval status
        return response()->json([
            'success' => true,
            'observation' => $observation
        ]);
    }
} 
<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use App\Models\PublicWeatherObservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicWeatherObservationController extends Controller
{
    /**
     * Show the form for creating a new public weather observation.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('public-user.public-form');
    }

    /**
     * Store a newly created public weather observation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'personal_name' => 'required|string|max:255',
            'personal_phone' => 'required|string|max:20',
            'personal_email' => 'required|email|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location_city' => 'required|string',
            'location_state' => 'required|string',
            'time_zone' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'weather_types' => 'required|array',
            'damages' => 'nullable|array',
            'other_damage_description' => 'nullable|string|required_if:damages.*,other_damage',
            'event_description' => 'nullable|string',
            'media_files' => 'nullable|array',
            'media_files.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240'
        ]);

        // Handle file uploads
        $mediaFiles = [];
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $path = $file->store('public-weather-observations', 'public');
                $mediaFiles[] = $path;
            }
        }

        // Create the public observation
        $observation = PublicWeatherObservation::create([
            'personal_name' => $validated['personal_name'],
            'personal_phone' => $validated['personal_phone'],
            'personal_email' => $validated['personal_email'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'location_city' => $validated['location_city'],
            'location_state' => $validated['location_state'],
            'time_zone' => $validated['time_zone'],
            'event_date' => $validated['event_date'],
            'event_time' => $validated['event_time'],
            'weather_types' => $validated['weather_types'],
            'damages' => $this->processDamages($request),
            'event_description' => $validated['event_description'],
            'media_files' => $mediaFiles,
            'status' => 'pending' // Default status for public submissions
        ]);

        // Handle AJAX requests differently
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Weather observation submitted successfully! Thank you for your contribution.',
                'redirect' => route('public.weather.observation.thank-you')
            ]);
        }

        // Regular form submission response
        return redirect()->route('public.weather.observation.thank-you')
            ->with('success', 'Weather observation submitted successfully! Thank you for your contribution.');
    }

    /**
     * Process damages data to include other_damage_description when applicable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function processDamages(Request $request)
    {
        $damages = $request->input('damages', []);
        
        // If "other_damage" is selected and description is provided, add it to the damages data
        if (in_array('other_damage', $damages) && $request->has('other_damage_description')) {
            $damages['other_damage_description'] = $request->input('other_damage_description');
        }
        
        return $damages;
    }

    /**
     * Display a thank you page after successful submission.
     *
     * @return \Illuminate\View\View
     */
    public function thankYou()
    {
        return view('public-user.thank-you');
    }
}

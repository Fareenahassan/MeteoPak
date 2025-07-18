<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountApproved;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware is applied in routes
    }

    /**
     * Display a listing of the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->with(['region', 'station']);
        
        // Status filter
        $status = $request->query('status');
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        // Search functionality
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('personal_number', 'LIKE', "%{$search}%");
            });
        }
        
        // Region filter
        $regionId = $request->query('region_id');
        if ($regionId) {
            $query->where('region_id', $regionId);
        }
        
        // Station filter
        $stationId = $request->query('station_id');
        if ($stationId) {
            $query->where('station_id', $stationId);
        }
        
        $users = $query->latest()->paginate(15);
        
        // Get all regions for the filter dropdown
        $regions = \App\Models\Region::orderBy('name')->get();
        
        // Get stations for the filter dropdown
        // If region is selected, get stations for that region only
        $stations = collect();
        if ($regionId) {
            $stations = \App\Models\Station::where('region_id', $regionId)
                ->orderBy('name')
                ->get();
        } else {
            // Get all stations with their regions for display
            $stations = \App\Models\Station::with('region')
                ->orderBy('name')
                ->get();
        }
        
        return view('admin.users.index', compact('users', 'regions', 'stations'));
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Approve the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(User $user)
    {
        if ($user->status === 'inactive') {
            $user->status = 'active';
            $user->save();
            
            // Send email notification
            Mail::to($user->email)->send(new AccountApproved($user));
            
            return redirect()->route('admin.users.index', ['status' => 'inactive'])
                ->with('success', 'User has been approved successfully and notification email has been sent.');
        }
        
        return redirect()->route('admin.users.index', ['status' => 'inactive'])
            ->with('info', 'User is already active.');
    }
    
    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User has been deleted successfully.');
    }
    
    /**
     * Get stations for a specific region (AJAX endpoint).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStationsByRegion(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
        ]);
        
        $stations = \App\Models\Station::where('region_id', $request->region_id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        
        return response()->json($stations);
    }
}
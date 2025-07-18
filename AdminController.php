<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Region;
use App\Models\WeatherObservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // User statistics
        $pending_users = User::where('status', 'inactive')->count();
        $active_users = User::where('status', 'active')->where('role', 'user')->count();
        $total_users = User::where('role', 'user')->count();
        
        // Recent inactive users for approval
        $recent_inactive_users = User::where('status', 'inactive')
            ->with(['region', 'station'])
            ->latest()
            ->take(5)
            ->get();
            
        // Region statistics
        $region_stats = Region::withCount(['users' => function($query) {
                $query->where('role', 'user');
            }])
            ->get()
            ->map(function($region) {
                return [
                    'id' => $region->id,
                    'name' => $region->name,
                    'count' => $region->users_count
                ];
            });
            
        // Designation statistics
        $designation_stats = User::where('role', 'user')
            ->select('designation', DB::raw('count(*) as count'))
            ->groupBy('designation')
            ->get();
            
        // Weather observation statistics
        $pending_observations = WeatherObservation::where('status', 'pending')->count();
        $approved_observations = WeatherObservation::where('status', 'approved')->count();
        $flagged_observations = WeatherObservation::where('status', 'flagged')->count();
        $total_observations = WeatherObservation::count();
        
        // Recent pending observations
        $recent_pending_observations = WeatherObservation::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'pending_users',
            'active_users',
            'total_users',
            'recent_inactive_users',
            'region_stats',
            'designation_stats',
            'pending_observations',
            'approved_observations',
            'flagged_observations',
            'total_observations',
            'recent_pending_observations'
        ));
    }
}
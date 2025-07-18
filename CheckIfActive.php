<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->status !== 'active') {
            auth()->logout();
            
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your account is pending admin approval.'], 403);
            }
            
            return redirect()->route('login')
                ->with('error', 'Your account is pending admin approval.');
        }
        
        return $next($request);
    }
}
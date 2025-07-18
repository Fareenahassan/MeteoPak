<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            
            return redirect()->route('login');
        }
        
        if (auth()->user()->status !== 'active') {
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
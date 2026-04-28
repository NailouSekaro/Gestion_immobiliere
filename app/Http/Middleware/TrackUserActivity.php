<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackUserActivity
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
        if (Auth::check()) {
            $userId = Auth::id();

            // 1. Cache pour vérification rapide (isOnline)
            Cache::put('user-online-' . $userId, true, now()->addMinutes(5));

            // 2. Mettre à jour last_seen_at en BDD (toutes les 2 minutes pour éviter trop de requêtes)
            $cacheKey = 'user-last-update-' . $userId;

            if (!Cache::has($cacheKey)) {
                // Mettre à jour last_seen_at
                Auth::user()->update(['last_seen_at' => now()]);

                // Mettre en cache pour ne pas refaire la requête pendant 2 minutes
                Cache::put($cacheKey, true, now()->addMinutes(2));
            }
        }

        return $next($request);
    }
}

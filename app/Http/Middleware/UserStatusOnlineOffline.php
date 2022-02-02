<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Cache;

class UserStatusOnlineOffline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
           $expireAt = Carbon::now()->addMinutes(30);
           // $expireAt = Carbon::now()->addSeconds(60);

            Cache::put('user-is-online-'. Auth::id() ,true,$expireAt);
        }
        return $next($request);
    }
}

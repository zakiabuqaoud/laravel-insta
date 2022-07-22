<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $min, $max = null)
    {
        $user = $request->user();
        $birthday = new Carbon($user->profile->birthday);
        $age = Carbon::now()->diff($birthday); // \DateInterval
        if (! ($age->y >= $min && ($max === null || $age->y <= $max))) {
            abort(403, 'Your age is small!');
        }

        return $next($request);
    }
}

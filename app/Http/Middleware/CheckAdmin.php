<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user =  auth()->user();
        if (!$user) {
            return $this->errorResponse("Unauthenticated.", 401);
        }
        if ($user->permission === 'admin') {
            return $next($request);
        } else {
            return $this->errorResponse("Unauthenticated.", 401);
        }
    }
}

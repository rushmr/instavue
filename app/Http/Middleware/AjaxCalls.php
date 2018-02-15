<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AjaxCalls
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
        if(!Auth::check()){
            return response()->json(['success' => 0, 'error' => 'Need to be authorized user for request']);
        }
        return $next($request);
    }
}

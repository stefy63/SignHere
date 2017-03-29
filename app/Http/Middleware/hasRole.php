<?php

namespace App\Http\Middleware;

use Closure;

class hasRole
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
        list($module,$op) = explode('.',$request->route()->action['as']);

        if (!\Auth::user()->hasRole($module,$op)) {
            return redirect()->back()->with('alert', __('app.error_operation'));
        }

        return $next($request);
    }
}

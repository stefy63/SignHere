<?php

namespace app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


class ForceSecure
{
    public function handle(Request $request, Closure $next)
    {

        if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
            dd($_SERVER['HTTP_X_FORWARDED_PROTO']);
            URL::forceScheme('https');
        }

            $isSecure = $request->header('x-forwarded-proto') == 'https';
            $isProduction = env('APP_ENV') === 'production';
            $isStaging = env('APP_ENV') === 'staging';

            //if ($isProduction) {
            //   $host = $_SERVER['HTTP_HOST'];
            //    if (!preg_match('/^www\..*/', $host)) {
            //        return redirect(env('APP_URL'));
            //    }
            //}

            /*if (!$isSecure && ($isProduction || $isStaging)) {
                return redirect(env('APP_URL'));
            }

            if ($isProduction || $isStaging) {
                URL::forceScheme('https');
            }*/

            return $next($request);
    }
}
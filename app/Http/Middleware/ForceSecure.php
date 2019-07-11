<?php

namespace app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;


class ForceSecure
{
    public function handle(Request $request, Closure $next)
    {

        if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
            URL::forceScheme('https');
        }

        date_default_timezone_set('Europe/Rome');

        $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        if ($locale != 'it' && $locale != 'es') {
            $locale = 'en';
        }
        App::setLocale($locale);

        return $next($request);
    }
}
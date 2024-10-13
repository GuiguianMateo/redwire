<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale');

        if (is_string($locale) && !empty($locale)) {
            App::setLocale($locale);
        } else {
            $defaultLocale = Config::get('app.locale');

            if (is_string($defaultLocale) && !empty($defaultLocale)) {
                App::setLocale($defaultLocale);
            }
        }

        return $next($request);
    }
}

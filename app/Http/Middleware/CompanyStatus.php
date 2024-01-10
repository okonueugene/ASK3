<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->wantsJson()) {
            if (auth()->check() && auth()->guard('web')->user()->company->status == false) {
                Auth::logout();
                return redirect(route('login'))->with('error', 'Your company has been deactivated, please contact support for assistance');
            }
        }

        return $next($request);
        }
}

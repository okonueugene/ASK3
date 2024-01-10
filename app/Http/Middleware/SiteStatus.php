<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->wantsJson()){
            if(auth()->guard('guard')->user()->site->is_active == false){
                return response()->json(['message' => 'site deactivated, please contact support'], 422);
            }
        }    }
}

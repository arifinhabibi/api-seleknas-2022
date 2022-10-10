<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\ResponseJSON;
use App\Models\Society;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Society::where('login_tokens', $request->token)->first();

        if (!$request->token || !$user) { 
            return response()->json([
                'message' => 'Invalid token'
            ], 401);
        }

        return $next($request);
    }
}

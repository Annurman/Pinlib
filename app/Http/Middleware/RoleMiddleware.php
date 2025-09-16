<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware extends StartSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
     public function handle(Request $request, Closure $next)
     {
         if ($request->is('admin/*')) {
             config(['session.cookie' => 'admin_session']);
         } else {
             config(['session.cookie' => 'user_session']);
         }
 
         return $next($request);
     }
    protected function redirectTo($request)
{
    if (!$request->expectsJson()) {
        if ($request->is('admin/*')) {
            return route('admin.login'); // Jika akses ke admin, redirect ke login admin
        }
        return route('auth.login'); // Jika akses ke user, redirect ke login user
    }
}

    

}

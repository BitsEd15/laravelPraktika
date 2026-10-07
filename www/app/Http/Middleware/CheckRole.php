<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user=$request->user();
        if (!$user) {
            abort(403,'Не атворизован');
        }
        if($user->role==='admin')
            return $next($request);
        if($user->role==='warden'){
            $method = $request->method();// это встроенный метод
            if($method==='GET') 
                return $next($request);
            else
                abort(403,'Нет прав');
        }
    }
}

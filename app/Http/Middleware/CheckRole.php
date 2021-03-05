<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roleNames)
    {
        if (!$request->user()->hasRoles($roleNames)) {
            return redirect()->to(route($request->user()->redirectTo()));
        }
        return $next($request);
    }
}

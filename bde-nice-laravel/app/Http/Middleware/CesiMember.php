<?php

namespace App\Http\Middleware;

use Closure;

class CesiMember
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
        if(session('role') != 3)
            return redirect('/')->withErrors("Vous n'avez pas les droits requis pour exécuter cette action");

        return $next($request);
    }
}

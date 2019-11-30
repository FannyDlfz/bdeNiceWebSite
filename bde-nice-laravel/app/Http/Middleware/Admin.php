<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if(session('role') != 2 || session('role') != 4)
            return redirect('/')->withErrors("Vous n'avez pas les droits requis pour exécuter cette action");

        return $next($request);
    }
}

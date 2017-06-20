<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use Closure;

class CustomAuth
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
        if (!isset($_SESSION['user'])){
            return redirect('login');
        }

        return $next($request);
    }
}

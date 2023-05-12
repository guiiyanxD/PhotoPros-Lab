<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Photographer
{

    ///TODO: 05/05/2023 18:10 AQUI ME QUEDE
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uid = Session::get('uid');
        $photographer = Session::get('is_photographer');
        if ($uid && $photographer) {
            return $next($request);
        }
        else {
            Session::flush();
            return redirect('/');
        }
    }
}

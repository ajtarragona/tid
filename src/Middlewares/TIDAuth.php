<?php

namespace Ajtarragona\TID\Middlewares;

use Closure;
use TID;

class TIDAuth
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
    	//comprobar autenticacion valid
        //si no esta autenticado, redirijo al formulario
        // dd(TID::isAuthenticated());
        if(!TID::isAuthenticated()){
            return TID::showLoginForm();
        }else{
            return $next($request);
        }
    }
}
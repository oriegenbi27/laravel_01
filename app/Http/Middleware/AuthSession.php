<?php

namespace App\Http\Middleware;
use Session;
use Closure;

class AuthSession
{
    public function handle($request, Closure $next)
    {
        $data = Session::get('authsession');
        if ($data == '01') { // authorized
            return $next($request);            
        }else{
            return redirect()->intended('/');
        }               
    }    
}
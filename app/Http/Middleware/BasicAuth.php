<?php

namespace App\Http\Middleware;

use Closure;

class BasicAuth
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
        $userName = $request->header('PHP_AUTH_USER');
        $password = $request->header('PHP_AUTH_PW');

        if(empty($userName) || empty($password))
        {
            abort(401, "Invalid username or password");
        }
        $user = \App\User::where([
            ['email' , '=', $userName],
            ['password', '=', $password]
        ])->first();
        if($user == null)
        {
            abort(401, "Invalid username or password");
        }
        return $next($request);
    }
}

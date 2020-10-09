<?php

namespace App\Http\Middleware;

use Closure;

class AccessControl
{
    public function handle($request, Closure $next, $admin, $user='', $invitee='' )
    {
        if( ! $request->user()->hasAnyRole([ $admin, $user, $invitee ])) {
            return redirect('/home')->with('error', 'Sorry, you don\'t have sufficient privileges to access that!' );
        }
        return $next($request);
    }
}

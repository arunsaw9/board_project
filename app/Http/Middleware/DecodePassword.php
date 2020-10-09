<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class DecodePassword
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

        // if( $request['_g-challenge'] && $request['_g-sync-token'] ) {
        //     $request->merge(['password' => base64_decode(base64_decode(base64_decode($request['_g-sync-token']))) ]);
        //     $request->merge(['otp' => base64_decode(base64_decode(base64_decode($request['_g-challenge']))) ]);
        // }

        if ($request['_g-token']) {
            $passwordArray = explode('.', $request['_g-token']);
            if ($passwordArray[0]) $request->merge(['password' => base64_decode(base64_decode(base64_decode($passwordArray[0])))]);
            if ($passwordArray[1]) $request->merge(['otp' => base64_decode(base64_decode(base64_decode($passwordArray[1])))]);
            // $request->merge(['password' => base64_decode(base64_decode(base64_decode($request['_g-token']))) ]);
        } else {
            abort(500);
        }

        if(!$request->password || !$request->otp) {
            abort(500);
        }

        return $next($request);
    }
}

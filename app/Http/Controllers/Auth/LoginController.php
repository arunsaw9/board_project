<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Jobs\OtpJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/home';
    protected $lockoutTime = 300;
    public $decayMinutes = 1;

    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'authCheck']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function show2factor()
    {
        return view('auth.2factor');
    }

    public function getOtp(Request $request)
    {

        $request->validate([
            'username' => 'required|numeric',
            'captcha' => 'required|captcha'
            // 'g-recaptcha-response' => 'required'
        ]);


        // $google_url = "https://www.google.com/recaptcha/api/siteverify";
        // $client = new Client();
        // $response = $client->request('POST', $google_url, [
        //     'form_params' => [
        //         'secret' => '6LcgLL4UAAAAAMwdDh6nqqlFLGMj6T8NH-Dcbfxo',
        //         'response' => $request['g-recaptcha-response']
        //     ],

        // ]);

        // $json = json_decode($response->getBody());
        // if (!$json->success) {
        //     return redirect('/login')->with('error', "ReCAPTCHA failed! Are you a Robot?");
        // }

        $user = User::where('username', $request->username)->first();
        if ($user && $user->mobile) {

            if ($user->otp_requests > 10 && Carbon::now()->lessThan($user->otp_expires_at)) {
                // $this->fireLockoutEvent($request);
                // return $this->sendLockoutResponse($request);
                $diff = Carbon::now()->diffInSeconds($user->otp_expires_at);
                return redirect('/login')->with('error', "Too many login attempts. Please try again in $diff seconds");
            } else {

                $user->otp = mt_rand(100000, 999999);
                $user->otp_expires_at = Carbon::now()->addMinutes(15);
                $user->otp_requests = $user->otp_requests + 1;
                $user->save();

                if (config('app.env') == 'production') {
                    OtpJob::dispatch($user);
                }
            }

            return view('auth.2factor', compact('user'));
        } else {
            abort(404);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|numeric',
            'otp' => 'required|numeric',
            'password' => 'required',
        ]);

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $request->only($this->username(), 'password', 'otp'),
            false
        );
    }

    protected function authenticated(Request $request, $user)
    {
        $user->otp_expires_at = null;
        $user->otp_requests = 0;
        $user->save();
    }

    public function username()
    {
        return 'username';
    }

    public function authCheck()
    {
        return Auth::check() ? 'true' : 'false';
    }
}

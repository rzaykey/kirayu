<?php

namespace App\Http\Controllers;

use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function dologin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->role_id !== null) {
                $request->user()->update([
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                    'last_login_ip' => $request->getClientIp(),
                    'last_login_mac' => substr(shell_exec('getmac'), 159, 20)
                ]);
                FacadesAlert::success('Hore!', 'Login Successfully');
                return redirect()->intended('/dashboard');
            } else {
                return redirect()->intended('/');
            }
        }
        return back()->with('error', 'email atau password salah');
    }

    function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp(),
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
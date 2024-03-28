<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function cek()
    {
        if (auth()->user()->role_id !== null) {
            return redirect('/dashboard');
            // } elseif (auth()->user()->role_id === 2) {
            //     return redirect('/direktur');
            // } else {
            return redirect('/');
        }
    }
}
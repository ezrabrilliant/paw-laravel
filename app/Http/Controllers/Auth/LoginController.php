<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->admin_access === 1) {
                return redirect()->intended('/admin');
            }
            if (Auth::user()->driver_access === 1) {
                return redirect()->intended('/driver');
            }
            return redirect()->intended('/');
        }

        return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
    }
}

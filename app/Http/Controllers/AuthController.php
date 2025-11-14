<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if (!$user->aktif) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda tidak aktif.']);
            }

            return redirect()->intended($this->redirectPath($user));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    private function redirectPath($user)
    {
        if ($user->isAdmin()) {
            return '/admin/dashboard';
        } elseif ($user->isPetugas()) {
            return '/petugas/dashboard';
        } elseif ($user->isBendahara()) {
            return '/bendahara/dashboard';
        } elseif ($user->isOwner()) {
            return '/owner/dashboard';
        }
        
        return '/';
    }
}

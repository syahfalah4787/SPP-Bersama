<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('siswa.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nisn' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('siswa')->attempt(['nisn' => $credentials['nisn'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('siswa.dashboard'));
        }

        return back()->withErrors(['nisn' => 'NISN atau password salah.'])->onlyInput('nisn');
    }

    public function logout(Request $request)
    {
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('siswa.login');
    }
}

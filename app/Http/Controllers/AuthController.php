<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginField = $request->login;

        // Validate based on whether it's an email or phone number
        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            // It's an email
            $request->validate([
                'login' => 'required|email',
                'password' => 'required',
            ]);
            $field = 'email_232112';
        } else {
            // It's a phone number, validate phone number format
            $request->validate([
                'login' => 'required|string|regex:/^[0-9+\-\s\(\)]{10,15}$/',
                'password' => 'required',
            ]);
            $field = 'telepon_232112';
        }

        $user = User::where($field, $loginField)->first();

        if ($user && Hash::check($request->password, $user->password_232112)) {
            Auth::login($user);
            $request->session()->regenerate();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'login' => 'Email atau nomor telepon atau password salah.',
        ])->onlyInput('login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users_232112,email_232112',
            'password' => 'required|min:6|confirmed',
            'telepon' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'nama_232112' => $request->nama,
            'email_232112' => $request->email,
            'password_232112' => Hash::make($request->password),
            'role_232112' => 'user',
            'telepon_232112' => $request->telepon,
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
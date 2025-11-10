<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    
    private $users = [
        'admin' => [
            'email' => 'admin@sportvenue.com',
            'password' => 'admin123',
            'name' => 'Admin SportVenue',
            'role' => 'admin',
            'phone' => '081234567890'
        ],
        'user' => [
            'email' => 'user@sportvenue.com',
            'password' => 'user123',
            'name' => 'Rahmat',
            'role' => 'user',
            'phone' => '081298765432'
        ]
    ];

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|string|max:15',
            'user_type' => 'required|in:user,admin'
        ]);

        Session::put('user', [
            'email' => $request->email,
            'name' => $request->name,
            'role' => $request->user_type,
            'phone' => $request->phone,
            'logged_in' => true,
            'is_temporary' => true
        ]);

        $notificationController = new NotificationController();
        $notificationController->sendNotification(
            $request->email,
            'Registrasi Berhasil',
            'Selamat datang ' . $request->name . '! Akun SportVenue Anda berhasil dibuat.',
            'email'
        );

        return redirect()->route($request->user_type . '.dashboard')->with('success', 'Registrasi berhasil! Selamat datang ' . $request->name . ' (Akun temporary)');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'user_type' => 'required|in:user,admin'
        ]);

        $email = $request->email;
        $password = $request->password;

        // First try to authenticate against database users
        try {
            if (class_exists('\App\Models\UserLegacy')) {
                $user = \App\Models\UserLegacy::where('email_232112', $email)->first();

                if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password_232112)) {
                    // Map database role to session role
                    $sessionRole = $user->role_232112 === 'user' ? 'user' : $user->role_232112;

                    Session::put('user', [
                        'id' => $user->user_id_232112,
                        'email' => $user->email_232112,
                        'name' => $user->nama_232112,
                        'role' => $sessionRole,
                        'phone' => $user->telepon_232112,
                        'logged_in' => true,
                        'is_temporary' => false
                    ]);

                    $notificationController = new NotificationController();
                    $notificationController->sendNotification(
                        $user->email_232112,
                        'Login Berhasil',
                        'Halo ' . $user->nama_232112 . '! Anda berhasil login ke SportVenue.',
                        'email'
                    );

                    return redirect()->route($sessionRole . '.dashboard');
                }
            }
        } catch (\Exception $e) {
            // If DB authentication fails, fall back to hardcoded users
        }

        // Fallback to hardcoded users if DB is not available or user not found
        $userType = $request->user_type;

        if (isset($this->users[$userType])) {
            $user = $this->users[$userType];

            if ($email === $user['email'] && $password === $user['password']) {
                Session::put('user', [
                    'email' => $user['email'],
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'phone' => $user['phone'],
                    'logged_in' => true,
                    'is_temporary' => false
                ]);

                $notificationController = new NotificationController();
                $notificationController->sendNotification(
                    $user['email'],
                    'Login Berhasil',
                    'Halo ' . $user['name'] . '! Anda berhasil login ke SportVenue.',
                    'email'
                );

                return redirect()->route($user['role'] . '.dashboard');
            }
        }

        return back()->with('error', 'Email atau password salah!')->withInput();
    }

    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout!');
    }

    private function checkAuth()
    {
        if (!Session::has('user') || !Session::get('user')['logged_in']) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }
        return null;
    }

    public function userDashboard()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $user = Session::get('user');
        if ($user['role'] !== 'user') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak!');
        }

        // Load lapangan locations from legacy table and pass to view
        try {
            $locations = [];
            if (class_exists('\App\\Models\\Lapangan')) {
                $locations = \App\Models\Lapangan::where('status_232112', 'active')->get();
            }
        } catch (\Exception $e) {
            // If DB is not available or query fails, fallback to empty array
            $locations = [];
        }

        return view('user.dashboard', ['user' => $user, 'locations' => $locations]);
    }

    public function adminDashboard()
    {
        if ($redirect = $this->checkAuth()) return $redirect;
        
        $user = Session::get('user');
        if ($user['role'] !== 'admin') {
            return redirect()->route('user.dashboard')->with('error', 'Akses ditolak!');
        }

        return view('admin.dashboard', ['user' => $user]);
    }
}
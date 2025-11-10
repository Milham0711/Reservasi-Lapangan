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

        $userType = $request->user_type;
        $email = $request->email;
        $password = $request->password;
        
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

        return view('user.dashboard', ['user' => $user]);
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
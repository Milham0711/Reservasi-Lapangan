<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users_232112,email_232112'
        ]);

        $user = User::where('email_232112', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Alamat email tidak ditemukan.']);
        }

        // Create password reset token
        $token = Str::random(60);
        
        // Store the token in the database (you'll need to create a password_resets table)
        \DB::table('password_resets_232112')->insert([
            'email_232112' => $request->email,
            'token_232112' => hash('sha256', $token),
            'created_at_232112' => now(),
        ]);

        // For now, we'll just return success message since we don't have email configuration
        // In a real application, you would send an email here with the reset link
        return back()->with('status', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau spam folder Anda.');
    }

    public function showResetForm($token = null)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users_232112,email_232112',
            'password' => 'required|min:6|confirmed',
        ]);

        // Find the reset token
        $reset = \DB::table('password_resets_232112')
            ->where('email_232112', $request->email)
            ->where('token_232112', hash('sha256', $request->token))
            ->first();

        if (!$reset) {
            return back()->withErrors(['token' => 'Token reset password tidak valid.']);
        }

        // Check if token is expired (older than 1 hour)
        $createdAt = \Carbon\Carbon::parse($reset->created_at_232112);
        if ($createdAt->diffInHours(now()) >= 1) {
            // Delete expired token
            \DB::table('password_resets_232112')
                ->where('email_232112', $request->email)
                ->where('token_232112', hash('sha256', $request->token))
                ->delete();
            
            return back()->withErrors(['token' => 'Token reset password sudah kadaluarsa. Silakan minta ulang.']);
        }

        // Update user password
        $user = User::where('email_232112', $request->email)->first();
        $user->update([
            'password_232112' => Hash::make($request->password),
            'updated_at_232112' => now(),
        ]);

        // Delete the used token
        \DB::table('password_resets_232112')
            ->where('email_232112', $request->email)
            ->where('token_232112', hash('sha256', $request->token))
            ->delete();

        event(new PasswordReset($user));

        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login kembali.');
    }
}
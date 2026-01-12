<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_email()
    {
        $user = User::create([
            'nama_232112' => 'Test User',
            'email_232112' => 'test@example.com',
            'password_232112' => Hash::make('password'),
            'role_232112' => 'user',
            'telepon_232112' => '081234567890',
        ]);

        $response = $this->withoutMiddleware()->post('/login', [
            'login' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_login_with_phone_number()
    {
        $user = User::create([
            'nama_232112' => 'Test User',
            'email_232112' => 'test@example.com',
            'password_232112' => Hash::make('password'),
            'role_232112' => 'user',
            'telepon_232112' => '081234567890',
        ]);

        $response = $this->withoutMiddleware()->post('/login', [
            'login' => '081234567890',
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        $user = User::create([
            'nama_232112' => 'Test User',
            'email_232112' => 'test@example.com',
            'password_232112' => Hash::make('password'),
            'role_232112' => 'user',
            'telepon_232112' => '081234567890',
        ]);

        $response = $this->withoutMiddleware()->post('/login', [
            'login' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_login_fails_with_invalid_phone_number_format()
    {
        $response = $this->withoutMiddleware()->post('/login', [
            'login' => 'invalid-phone-number',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_login_validation_requires_both_fields()
    {
        $response = $this->withoutMiddleware()->post('/login', [
            'login' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['login', 'password']);
    }
}
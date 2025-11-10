<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SportVenue Reservation</title>
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>SportVenue Reservation</h1>
            <p>Sistem Reservasi Lapangan Olahraga</p>
        </div>
        
        <div class="login-type">
            <button type="button" class="login-type-btn active" id="userBtn">Member</button>
            <button type="button" class="login-type-btn" id="adminBtn">Admin</button>
        </div>
        
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" id="user_type" name="user_type" value="user">

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email Anda" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password Anda" required>
            </div>

            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingatkan saya</label>
                </div>
                <a href="#" class="forgot-password" onclick="showComingSoon()">Lupa password?</a>
            </div>

            <button type="submit" class="login-btn" id="loginBtn">Masuk sebagai Member</button>

            <div class="register-link">
                Belum menjadi member? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </div>

            <div class="test-credentials" style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                <h4 style="margin: 0 0 10px 0; color: #495057; font-size: 14px;">Test Credentials:</h4>
                <div style="font-size: 12px; color: #6c757d;">
                    <strong>Admin:</strong> admin@sportvenue.com / admin123<br>
                    <strong>User:</strong> user@sportvenue.com / user123<br>
                    <strong>John Doe:</strong> john@example.com / password
                </div>
            </div>
        </form>
    </div>

    <script>
        function showComingSoon() {
            alert('Fitur lupa password sedang dalam pengembangan.');
            return false;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const userBtn = document.getElementById('userBtn');
            const adminBtn = document.getElementById('adminBtn');
            const loginBtn = document.getElementById('loginBtn');
            const userTypeInput = document.getElementById('user_type');
            
            if (userBtn && adminBtn) {
                userBtn.addEventListener('click', function() {
                    userBtn.classList.add('active');
                    adminBtn.classList.remove('active');
                    loginBtn.textContent = 'Masuk sebagai Member';
                    userTypeInput.value = 'user';
                });
                
                adminBtn.addEventListener('click', function() {
                    adminBtn.classList.add('active');
                    userBtn.classList.remove('active');
                    loginBtn.textContent = 'Masuk sebagai Admin';
                    userTypeInput.value = 'admin';
                });
            }
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SportVenue Reservation</title>
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Daftar Member Baru</h1>
            <p>Buat akun untuk mulai reservasi lapangan</p>
        </div>
        
        <div class="login-type">
            <button type="button" class="login-type-btn active" id="userBtn">Member</button>
            <button type="button" class="login-type-btn" id="adminBtn">Admin</button>
        </div>
        
        <form class="login-form" method="POST" action="{{ route('register') }}">
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
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="Masukkan nomor telepon" value="{{ old('phone') }}" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password (minimal 6 karakter)" required>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Masukkan ulang password" required>
            </div>
            
            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="agree" name="agree" required>
                    <label for="agree">Saya menyetujui syarat dan ketentuan</label>
                </div>
            </div>
            
            <button type="submit" class="login-btn" id="registerBtn">Daftar sebagai Member</button>
            
            <div class="register-link">
                Sudah memiliki akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userBtn = document.getElementById('userBtn');
            const adminBtn = document.getElementById('adminBtn');
            const registerBtn = document.getElementById('registerBtn');
            const userTypeInput = document.getElementById('user_type');
            
            if (userBtn && adminBtn) {
                userBtn.addEventListener('click', function() {
                    userBtn.classList.add('active');
                    adminBtn.classList.remove('active');
                    registerBtn.textContent = 'Daftar sebagai Member';
                    userTypeInput.value = 'user';
                });
                
                adminBtn.addEventListener('click', function() {
                    adminBtn.classList.add('active');
                    userBtn.classList.remove('active');
                    registerBtn.textContent = 'Daftar sebagai Admin';
                    userTypeInput.value = 'admin';
                });
            }
            
            const registerForm = document.querySelector('.login-form');
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('password_confirmation').value;
                    const agree = document.getElementById('agree').checked;
                    
                    if (password !== confirmPassword) {
                        e.preventDefault();
                        alert('Password dan konfirmasi password tidak sama!');
                        return false;
                    }
                    
                    if (!agree) {
                        e.preventDefault();
                        alert('Anda harus menyetujui syarat dan ketentuan!');
                        return false;
                    }
                    
                    return true;
                });
            }
        });
    </script>
</body>
</html>
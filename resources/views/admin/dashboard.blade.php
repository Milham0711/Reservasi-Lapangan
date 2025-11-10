<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SportVenue</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f8f9fa; }
        .navbar { background: linear-gradient(to right, #dc2626, #ef4444); color: white; padding: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 1rem; }
        .btn { background: #dc2626; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-secondary { background: #6c757d; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 10px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .stat-number { font-size: 2rem; font-weight: bold; color: #dc2626; }
        .admin-features { margin-top: 1rem; padding: 1rem; background: #fef2f2; border-radius: 5px; }
        .quick-actions { display: flex; gap: 1rem; flex-wrap: wrap; margin: 1rem 0; }
        .alert { padding: 12px; border-radius: 5px; margin-bottom: 1rem; }
        .alert-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee3f8; }
    </style>
</head>
<body>

    <nav class="navbar">
    <div class="container">
        <h1>SportVenue - Admin Dashboard</h1>
        <div style="display: flex; align-items: center; gap: 1.5rem; position: relative; z-index: 10000;">
            @include('components.notification-bell')
            <div>
                    <p style="margin: 0;">Welcome, {{ $user['name'] }}! | {{ $user['email'] }}</p>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container">
        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        @if(isset($user['is_temporary']) && $user['is_temporary'])
        <div class="alert alert-info">
            <strong>Info:</strong> Ini adalah akun temporary. Data registrasi Anda tidak disimpan secara permanen.
        </div>
        @endif

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div>Total Reservasi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">6</div>
                <div>Lapangan Tersedia</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">Rp 0</div>
                <div>Pendapatan Bulan Ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">2</div>
                <div>Member Aktif</div>
            </div>
        </div>

        <div class="card">
            <h2>Admin Quick Actions</h2>
            <div class="quick-actions">
                <a href="{{ route('admin.reservations') }}" class="btn">📋 Kelola Reservasi</a>
                <a href="#" class="btn" onclick="showComingSoon()">🏟️ Kelola Lapangan</a>
                <a href="#" class="btn" onclick="showComingSoon()">👥 Kelola Member</a>
                <a href="#" class="btn" onclick="showComingSoon()">📊 Laporan Keuangan</a>
                <a href="#" class="btn" onclick="showComingSoon()">⚙️ Pengaturan Sistem</a>
            </div>
        </div>

        <div class="card">
            <h2>Reservasi Hari Ini</h2>
            <div class="admin-features">
                <p><strong>0 Reservasi</strong> untuk hari ini</p>
                <p style="color: #666; margin-top: 0.5rem;">Belum ada reservasi yang masuk.</p>
            </div>
        </div>

        <div class="card">
            <h2>Informasi Admin</h2>
            <p style="color: #666;">Panel admin sedang dalam tahap pengembangan. Fitur-fitur manajemen akan segera tersedia.</p>
            <div class="admin-features">
                <h3>Fitur yang Akan Datang:</h3>
                <ul>
                    <li>Manajemen Reservasi</li>
                    <li>Manajemen Lapangan</li>
                    <li>Manajemen User/Member</li>
                    <li>Laporan dan Analytics</li>
                </ul>
            </div>
        </div>

        <div class="card">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn">🚪 Logout</button>
            </form>
        </div>
    </div>

    <script>
        function showComingSoon() {
            alert('Fitur admin sedang dalam pengembangan.');
            return false;
        }
    </script>
</body>
</html>
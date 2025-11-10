<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Saya - SportVenue</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f8f9fa; }
        .navbar { background: linear-gradient(to right, #6a11cb, #2575fc); color: white; padding: 1rem; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { background: #2575fc; color: white; padding: 8px 16px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 2px; }
        .btn-secondary { background: #6c757d; }
        .alert { padding: 12px; border-radius: 5px; margin-bottom: 1rem; }
        .alert-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee3f8; }
        .no-data { text-align: center; padding: 2rem; color: #666; }
        
        .reservation-item { 
            background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; 
            border-left: 4px solid #2575fc;
        }
        .reservation-header { display: flex; justify-content: between; align-items: center; margin-bottom: 0.5rem; }
        .reservation-field { font-weight: 600; color: #2d3748; }
        .reservation-price { font-weight: 700; color: #2575fc; }
        .reservation-details { color: #718096; font-size: 0.9rem; }
        .reservation-status { 
            display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; 
            font-weight: 600; margin-top: 0.5rem;
        }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>Reservasi Saya</h1>
            <p>Welcome, {{ $user['name'] }}!</p>
        </div>
    </nav>
    
    <div class="container">
        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h2>Daftar Reservasi Saya</h2>
                <a href="{{ route('reservations.create') }}" class="btn">➕ Buat Reservasi Baru</a>
            </div>

            @if(count($reservations) > 0)
                @foreach($reservations as $reservation)
                <div class="reservation-item">
                    <div class="reservation-header">
                        <div class="reservation-field">{{ $reservation['field_name'] }}</div>
                        <div class="reservation-price">Rp {{ number_format($reservation['total_price'], 0, ',', '.') }}</div>
                    </div>
                    <div class="reservation-details">
                        📅 {{ $reservation['date'] }} | ⏰ {{ $reservation['start_time'] }} ({{ $reservation['duration'] }} jam)
                    </div>
                    @if($reservation['status'] == 'confirmed')
                        <span class="reservation-status status-confirmed">Confirmed</span>
                    @else
                        <span class="reservation-status status-pending">Pending</span>
                    @endif
                </div>
                @endforeach
            @else
                <div class="no-data">
                    <p>Belum ada reservasi.</p>
                    <p style="color: #999; margin-top: 0.5rem;">Fitur reservasi sedang dalam pengembangan.</p>
                    <a href="{{ route('reservations.create') }}" class="btn" style="margin-top: 1rem;">Buat Reservasi Pertama</a>
                </div>
            @endif
            
            <div style="margin-top: 1rem;">
                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">↩️ Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
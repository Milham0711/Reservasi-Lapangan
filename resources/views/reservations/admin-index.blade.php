<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Reservasi - Admin SportVenue</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f8f9fa; }
        .navbar { background: linear-gradient(to right, #dc2626, #ef4444); color: white; padding: 1rem; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { background: #dc2626; color: white; padding: 8px 16px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 2px; }
        .btn-secondary { background: #6c757d; }
        .btn-disabled { background: #ccc; cursor: not-allowed; opacity: 0.6; }
        .alert { padding: 12px; border-radius: 5px; margin-bottom: 1rem; }
        .table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .table th { background: #f8f9fa; font-weight: 600; }
        .no-data { text-align: center; padding: 2rem; color: #666; }
        .status-confirmed { background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; }
        .status-pending { background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>Kelola Reservasi - Admin</h1>
            <p>Welcome, {{ $user['name'] }}!</p>
        </div>
    </nav>
    
    <div class="container">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h2>Semua Reservasi</h2>
                <div>
                    <span style="color: #666; margin-right: 1rem;">Total: {{ count($reservations) }} reservasi</span>
                    <a href="{{ route('admin.dashboard') }}" class="btn">📊 Kembali ke Dashboard</a>
                </div>
            </div>

            @if(count($reservations) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Lapangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Durasi</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>#{{ $reservation->reservasi_id_232112 }}</td>
                            <td>
                                <div>User ID: {{ $reservation->user_id_232112 }}</div>
                                <small style="color: #666;">{{ $reservation->created_at_232112 }}</small>
                            </td>
                            <td>{{ $reservation->lapangan ? $reservation->lapangan->name : 'Lapangan tidak ditemukan' }}</td>
                            <td>{{ $reservation->tanggal_reservasi_232112 }}</td>
                            <td>{{ $reservation->waktu_mulai_232112 }} - {{ $reservation->waktu_selesai_232112 }}</td>
                            <td>
                                @if($reservation->waktu_mulai_232112 && $reservation->waktu_selesai_232112)
                                    {{ \Carbon\Carbon::parse($reservation->waktu_mulai_232112)->diffInHours(\Carbon\Carbon::parse($reservation->waktu_selesai_232112)) }} jam
                                @else
                                    -
                                @endif
                            </td>
                            <td>Rp {{ number_format($reservation->total_harga_232112, 0, ',', '.') }}</td>
                            <td>
                                @if($reservation->status_reservasi_232112 == 'confirmed')
                                    <span class="status-confirmed">Confirmed</span>
                                @elseif($reservation->status_reservasi_232112 == 'cancelled')
                                    <span style="background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px;">Cancelled</span>
                                @elseif($reservation->status_reservasi_232112 == 'completed')
                                    <span style="background: #d1ecf1; color: #0c5460; padding: 4px 8px; border-radius: 4px;">Completed</span>
                                @else
                                    <span class="status-pending">Pending</span>
                                @endif
                                
                                @if($reservation->pembayaran->isNotEmpty())
                                    @if($reservation->pembayaran->first()->status_pembayaran_232112 == 'paid')
                                        <span class="status-confirmed">Paid</span>
                                    @else
                                        <span class="status-pending">Payment Pending</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-disabled" disabled>Edit</button>
                                <button class="btn btn-disabled" disabled>Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">
                    <p>Belum ada reservasi.</p>
                    <p style="color: #999; margin-top: 0.5rem;">Fitur manajemen reservasi sedang dalam pengembangan.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
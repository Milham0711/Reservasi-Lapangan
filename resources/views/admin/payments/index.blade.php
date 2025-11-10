<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pembayaran - SportVenue Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f8f9fa; }
        .navbar { background: linear-gradient(to right, #dc2626, #ef4444); color: white; padding: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .container { max-width: 1400px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 1rem; }
        .btn { background: #dc2626; color: white; padding: 8px 16px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 2px; font-size: 14px; }
        .btn-sm { padding: 4px 8px; font-size: 12px; }
        .btn-secondary { background: #6c757d; }
        .btn-success { background: #28a745; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-danger { background: #dc3545; }
        .table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6; }
        .table th { background: #f8f9fa; font-weight: 600; }
        .status { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .pagination { display: flex; justify-content: center; margin-top: 2rem; }
        .pagination a, .pagination span { padding: 8px 12px; margin: 0 2px; border: 1px solid #dee2e6; border-radius: 4px; text-decoration: none; color: #007bff; }
        .pagination .active { background: #007bff; color: white; }
        .alert { padding: 12px; border-radius: 5px; margin-bottom: 1rem; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .filters { display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap; }
        .filters select, .filters input { padding: 8px; border: 1px solid #dee2e6; border-radius: 4px; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <h1>SportVenue - Admin Panel</h1>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <a href="{{ route('admin.dashboard') }}" style="color: white; text-decoration: none;">← Kembali ke Dashboard</a>
                <div>Welcome, {{ $user['name'] }}</div>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <h2>Kelola Pembayaran</h2>

            <div class="filters">
                <select id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="rejected">Rejected</option>
                </select>
                <input type="date" id="dateFilter" placeholder="Filter by date">
                <button class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pembayaran</th>
                        <th>Kode Booking</th>
                        <th>Lapangan</th>
                        <th>Jumlah Bayar</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->pembayaran_id_232112 }}</td>
                        <td>{{ $payment->reservasi->kode_booking_232112 ?? 'N/A' }}</td>
                        <td>{{ $payment->reservasi->lapangan->nama_lapangan_232112 ?? 'N/A' }}</td>
                        <td>Rp {{ number_format($payment->jumlah_pembayaran_232112, 0, ',', '.') }}</td>
                        <td>{{ $payment->metode_pembayaran_232112 ?? 'Transfer' }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->tanggal_pembayaran_232112)->format('d/m/Y') }}</td>
                        <td>
                            <span class="status status-{{ $payment->status_pembayaran_232112 }}">
                                {{ ucfirst($payment->status_pembayaran_232112) }}
                            </span>
                        </td>
                        <td>
                            @if($payment->status_pembayaran_232112 == 'pending')
                                <button class="btn btn-success btn-sm" onclick="updateStatus({{ $payment->pembayaran_id_232112 }}, 'paid')">Setujui</button>
                                <button class="btn btn-danger btn-sm" onclick="updateStatus({{ $payment->pembayaran_id_232112 }}, 'rejected')">Tolak</button>
                            @endif
                            <button class="btn btn-warning btn-sm" onclick="viewDetails({{ $payment->pembayaran_id_232112 }})">Detail</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2rem;">
                            Belum ada pembayaran yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $payments->links() }}
        </div>
    </div>

    <script>
        function updateStatus(paymentId, status) {
            if (!confirm(`Apakah Anda yakin ingin ${status === 'paid' ? 'menyetujui' : 'menolak'} pembayaran ini?`)) {
                return;
            }

            fetch(`{{ url('/admin/payments') }}/${paymentId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status pembayaran berhasil diperbarui!');
                    location.reload();
                } else {
                    alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui status.');
            });
        }

        function viewDetails(paymentId) {
            alert('Fitur detail pembayaran sedang dalam pengembangan.');
        }

        function clearFilters() {
            document.getElementById('statusFilter').value = '';
            document.getElementById('dateFilter').value = '';
            // Implement filtering logic here if needed
        }
    </script>
</body>
</html>

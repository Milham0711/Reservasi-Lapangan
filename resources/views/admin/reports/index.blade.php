<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - SportVenue Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f8f9fa; }
        .navbar { background: linear-gradient(to right, #dc2626, #ef4444); color: white; padding: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .container { max-width: 1400px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 1rem; }
        .btn { background: #dc2626; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-secondary { background: #6c757d; }
        .btn-success { background: #28a745; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 10px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .stat-number { font-size: 2rem; font-weight: bold; color: #dc2626; }
        .chart-container { position: relative; height: 400px; margin: 2rem 0; }
        .table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .table th, .table td { padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6; }
        .table th { background: #f8f9fa; font-weight: 600; }
        .alert { padding: 12px; border-radius: 5px; margin-bottom: 1rem; }
        .alert-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee3f8; }
        .filters { display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap; }
        .filters select, .filters input { padding: 8px; border: 1px solid #dee2e6; border-radius: 4px; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="card">
            <h2>Laporan Keuangan</h2>

            <div class="filters">
                <select id="yearFilter">
                    <option value="{{ date('Y') }}">Tahun {{ date('Y') }}</option>
                    <option value="{{ date('Y') - 1 }}">Tahun {{ date('Y') - 1 }}</option>
                </select>
                <button class="btn btn-secondary" onclick="exportReport()">Export PDF</button>
                <button class="btn btn-success" onclick="printReport()">Print</button>
            </div>

            <div class="stats">
                <div class="stat-card">
                    <div class="stat-number">Rp {{ number_format(array_sum($monthlyRevenue), 0, ',', '.') }}</div>
                    <div>Total Pendapatan Tahun Ini</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ count($fieldUsage) }}</div>
                    <div>Lapangan Terpakai</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ array_sum($monthlyRevenue) > 0 ? round(array_sum($monthlyRevenue) / count(array_filter($monthlyRevenue)), 0) : 0 }}</div>
                    <div>Rata-rata Pendapatan/Bulan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ max($monthlyRevenue) }}</div>
                    <div>Bulan Terbaik</div>
                </div>
            </div>

            <div class="card">
                <h3>Grafik Pendapatan Bulanan</h3>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="card">
                <h3>Detail Pendapatan per Bulan</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Pendapatan</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalYear = array_sum($monthlyRevenue);
                        @endphp
                        @foreach($monthlyRevenue as $index => $revenue)
                        <tr>
                            <td>{{ \Carbon\Carbon::create()->month($index + 1)->format('F') }}</td>
                            <td>Rp {{ number_format($revenue, 0, ',', '.') }}</td>
                            <td>{{ $totalYear > 0 ? round(($revenue / $totalYear) * 100, 1) : 0 }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3>Statistik Penggunaan Lapangan</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Lapangan</th>
                            <th>Jumlah Reservasi</th>
                            <th>Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fieldUsage as $field)
                        <tr>
                            <td>{{ $field->nama_lapangan_232112 }}</td>
                            <td>{{ $field->reservasi_count ?? 0 }}</td>
                            <td>Rp {{ number_format(($field->reservasi_count ?? 0) * $field->harga_per_jam_232112, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Revenue Chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($monthlyRevenue),
                    backgroundColor: 'rgba(220, 38, 38, 0.6)',
                    borderColor: 'rgba(220, 38, 38, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        function exportReport() {
            alert('Fitur export PDF sedang dalam pengembangan.');
        }

        function printReport() {
            window.print();
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - SportVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-blue-600">SportVenue</span>
                    <span class="ml-3 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Admin</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ Auth::user()->nama_232112 }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white min-h-screen shadow-lg">
            <nav class="p-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.lapangan.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Kelola Lapangan</span>
                </a>
                <a href="{{ route('admin.reservasi.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>Kelola Reservasi</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Kelola User</span>
                </a>
                <a href="{{ route('admin.report.index') }}" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="font-semibold">Laporan</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Laporan & Analisis</h1>
                <p class="text-gray-600 mt-1">Statistik pendapatan dan aktivitas reservasi</p>
            </div>

            <!-- Filter Controls -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <h2 class="text-xl font-bold text-gray-800">Filter Laporan</h2>
                    <div class="flex flex-wrap gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                            <select id="periodType" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="all" {{ request('period_type') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                                <option value="daily" {{ request('period_type') == 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="weekly" {{ request('period_type') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                <option value="monthly" {{ request('period_type') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                <option value="yearly" {{ request('period_type') == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Awal</label>
                            <input type="date" id="startDate" value="{{ request('start_date') }}" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                            <input type="date" id="endDate" value="{{ request('end_date') }}" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex items-end">
                            <button id="applyFilter" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Pendapatan</h3>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-green-100 text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Pendapatan {{ $currentPeriodLabel ?? 'Periode Ini' }}</h3>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalPendapatanCurrentPeriod, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Reservasi</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalReservasi }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Reservasi {{ $currentPeriodLabel ?? 'Periode Ini' }}</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalReservasiCurrentPeriod }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Buttons -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 sm:mb-0">Ekspor Laporan</h2>
                    <div class="flex space-x-4">
                        <form id="exportExcelForm" method="POST" action="{{ route('admin.report.export.excel') }}" class="inline">
                            @csrf
                            <input type="hidden" id="exportPeriodType" name="period_type" value="{{ request('period_type', 'all') }}">
                            <input type="hidden" id="exportStartDate" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" id="exportEndDate" name="end_date" value="{{ request('end_date') }}">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg hover:shadow-xl flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Ekspor ke Excel
                            </button>
                        </form>
                        <form id="exportPdfForm" method="POST" action="{{ route('admin.report.export.pdf') }}" class="inline">
                            @csrf
                            <input type="hidden" id="exportPeriodTypePdf" name="period_type" value="{{ request('period_type', 'all') }}">
                            <input type="hidden" id="exportStartDatePdf" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" id="exportEndDatePdf" name="end_date" value="{{ request('end_date') }}">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg hover:shadow-xl flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Ekspor ke PDF
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Monthly Income Chart -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Pendapatan Bulanan (12 Bulan Terakhir)</h2>
                    <div class="h-80">
                        <canvas id="monthlyIncomeChart"></canvas>
                    </div>
                </div>

                <!-- Top Lapangan Chart -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">5 Lapangan dengan Pendapatan Tertinggi</h2>
                    <div class="h-80">
                        <canvas id="topLapanganChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        let monthlyIncomeChart = null;
        let topLapanganChart = null;

        // Function to fetch and update report data
        function updateReportData() {
            // Get filter values
            const periodType = document.getElementById('periodType').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            // Update export form hidden fields
            document.getElementById('exportPeriodType').value = periodType;
            document.getElementById('exportStartDate').value = startDate;
            document.getElementById('exportEndDate').value = endDate;
            document.getElementById('exportPeriodTypePdf').value = periodType;
            document.getElementById('exportStartDatePdf').value = startDate;
            document.getElementById('exportEndDatePdf').value = endDate;

            // Build query parameters
            const params = new URLSearchParams();
            if (periodType) params.append('period_type', periodType);
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);

            // Fetch report data
            fetch("{{ route('admin.report.data') }}?" + params.toString())
                .then(response => response.json())
                .then(data => {
                    // Update Monthly Income Chart
                    if (monthlyIncomeChart) {
                        monthlyIncomeChart.destroy();
                    }

                    const monthlyIncomeCtx = document.getElementById('monthlyIncomeChart').getContext('2d');
                    monthlyIncomeChart = new Chart(monthlyIncomeCtx, {
                        type: 'line',
                        data: {
                            labels: data.chartData.map(item => item.month || item.day || item.label),
                            datasets: [{
                                label: 'Pendapatan',
                                data: data.chartData.map(item => item.income),
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
                                fill: true
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
                                            return 'Rp ' + value.toLocaleString();
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });

                    // Update Top Lapangan Chart
                    if (topLapanganChart) {
                        topLapanganChart.destroy();
                    }

                    const topLapanganCtx = document.getElementById('topLapanganChart').getContext('2d');
                    topLapanganChart = new Chart(topLapanganCtx, {
                        type: 'bar',
                        data: {
                            labels: data.topLapangan.map(item => item.nama_lapangan_232112),
                            datasets: [{
                                label: 'Pendapatan',
                                data: data.topLapangan.map(item => item.total_income),
                                backgroundColor: '#10b981',
                                borderColor: '#059669',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + value.toLocaleString();
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Apply filter button event
        document.getElementById('applyFilter').addEventListener('click', updateReportData);

        // When period type changes, update date fields as needed
        document.getElementById('periodType').addEventListener('change', function() {
            const periodType = this.value;
            // When "all" is selected, allow custom dates but clear if not needed
            if (periodType === 'all') {
                // For "all" period, dates are optional but can remain if user wants
            } else {
                // For other periods, user may want to clear custom dates for clarity
                // But we don't force clear to let user decide
            }
        });

        // Initialize charts on page load
        updateReportData();
    </script>
</body>
</html>
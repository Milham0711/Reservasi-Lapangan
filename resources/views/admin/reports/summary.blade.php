<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Laporan - SportVenue</title>
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
                <div class="border-t border-gray-200 my-2 pt-2">
                    <a href="{{ route('admin.report.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg mb-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="font-semibold">Semua Laporan</span>
                    </a>
                    <a href="{{ route('admin.reports.daily') }}" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg mb-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-semibold">Laporan Harian</span>
                    </a>
                    <a href="{{ route('admin.reports.monthly') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg mb-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Laporan Bulanan</span>
                    </a>
                    <a href="{{ route('admin.reports.yearly') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Laporan Tahunan</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Ringkasan Laporan</h1>
                <p class="text-gray-600 mt-1">Laporan pendapatan dan aktivitas harian, bulanan, dan tahunan</p>
            </div>

            <!-- Daily Report Section -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Laporan Harian
                        </h2>
                        <p class="text-gray-600">Statistik pendapatan dan reservasi hari ini</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button onclick="loadReport('daily')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition mr-2">
                            Tampilkan Hari Ini
                        </button>
                        <button onclick="toggleCustomDate('daily')" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                            Tanggal Kustom
                        </button>
                    </div>
                </div>

                <div id="dailyCustomDateContainer" class="mb-6 p-4 bg-gray-50 rounded-lg hidden">
                    <div class="flex items-end space-x-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Tanggal</label>
                            <input type="date" id="dailyDate" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button onclick="loadSpecificDailyReport()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                            Tampilkan
                        </button>
                        <button onclick="toggleCustomDate('daily')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                            Batal
                        </button>
                    </div>
                </div>

                <!-- Daily Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-blue-600">Pendapatan Hari Ini</h3>
                                <p class="text-2xl font-bold text-gray-900" id="dailyIncome">Rp 0</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-xl p-5 border border-green-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-green-100 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-green-600">Reservasi Hari Ini</h3>
                                <p class="text-2xl font-bold text-gray-900" id="dailyReservations">0</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 rounded-xl p-5 border border-purple-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-purple-600">Konfirmasi Hari Ini</h3>
                                <p class="text-2xl font-bold text-gray-900" id="dailyConfirmed">0</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-yellow-600">Rata-rata Waktu</h3>
                                <p class="text-2xl font-bold text-gray-900" id="dailyAvgDuration">0 jam</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daily Chart -->
                <div class="h-80">
                    <canvas id="dailyChart"></canvas>
                </div>
                
                <!-- Daily Export Buttons -->
                <div class="mt-6 flex justify-end space-x-4">
                    <form id="dailyExportExcelForm" method="POST" action="{{ route('admin.reports.export', ['type' => 'daily']) }}" class="inline">
                        @csrf
                        <input type="hidden" name="report_type" value="daily">
                        <input type="hidden" id="dailyDateHidden" name="date" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ekspor Excel
                        </button>
                    </form>
                    <form id="dailyExportPdfForm" method="POST" action="{{ route('admin.reports.export.pdf', ['type' => 'daily']) }}" class="inline">
                        @csrf
                        <input type="hidden" name="report_type" value="daily">
                        <input type="hidden" id="dailyDateHiddenPdf" name="date" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ekspor PDF
                        </button>
                    </form>
                </div>
            </div>

            <!-- Monthly Report Section -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Laporan Bulanan
                        </h2>
                        <p class="text-gray-600">Statistik pendapatan dan reservasi bulan ini</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button onclick="loadReport('monthly')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition mr-2">
                            Tampilkan Bulan Ini
                        </button>
                        <button onclick="toggleCustomMonth('monthly')" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                            Bulan Kustom
                        </button>
                    </div>
                </div>

                <div id="monthlyCustomDateContainer" class="mb-6 p-4 bg-gray-50 rounded-lg hidden">
                    <div class="flex items-end space-x-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Bulan/Tahun</label>
                            <input type="month" id="monthlyDate" value="{{ \Carbon\Carbon::now()->format('Y-m') }}" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button onclick="loadSpecificMonthlyReport()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                            Tampilkan
                        </button>
                        <button onclick="toggleCustomMonth('monthly')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                            Batal
                        </button>
                    </div>
                </div>

                <!-- Monthly Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-blue-600">Pendapatan Bulan Ini</h3>
                                <p class="text-2xl font-bold text-gray-900" id="monthlyIncome">Rp 0</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-xl p-5 border border-green-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-green-100 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-green-600">Reservasi Bulan Ini</h3>
                                <p class="text-2xl font-bold text-gray-900" id="monthlyReservations">0</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 rounded-xl p-5 border border-purple-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-purple-600">Rata-rata Harian</h3>
                                <p class="text-2xl font-bold text-gray-900" id="monthlyDailyAvg">0</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-yellow-600">Puncak Aktivitas</h3>
                                <p class="text-2xl font-bold text-gray-900" id="monthlyPeakDay">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Chart -->
                <div class="h-80">
                    <canvas id="monthlyChart"></canvas>
                </div>
                
                <!-- Monthly Export Buttons -->
                <div class="mt-6 flex justify-end space-x-4">
                    <form id="monthlyExportExcelForm" method="POST" action="{{ route('admin.reports.export', ['type' => 'monthly']) }}" class="inline">
                        @csrf
                        <input type="hidden" name="report_type" value="monthly">
                        <input type="hidden" id="monthlyDateHidden" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ekspor Excel
                        </button>
                    </form>
                    <form id="monthlyExportPdfForm" method="POST" action="{{ route('admin.reports.export.pdf', ['type' => 'monthly']) }}" class="inline">
                        @csrf
                        <input type="hidden" name="report_type" value="monthly">
                        <input type="hidden" id="monthlyDateHiddenPdf" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ekspor PDF
                        </button>
                    </form>
                </div>
            </div>

            <!-- Yearly Report Section -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Laporan Tahunan
                        </h2>
                        <p class="text-gray-600">Statistik pendapatan dan reservasi tahun ini</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button onclick="loadReport('yearly')" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold transition mr-2">
                            Tampilkan Tahun Ini
                        </button>
                        <button onclick="toggleCustomYear('yearly')" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                            Tahun Kustom
                        </button>
                    </div>
                </div>

                <div id="yearlyCustomDateContainer" class="mb-6 p-4 bg-gray-50 rounded-lg hidden">
                    <div class="flex items-end space-x-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Tahun</label>
                            <input type="number" id="yearlyDate" value="{{ \Carbon\Carbon::now()->year }}" min="2020" max="{{ \Carbon\Carbon::now()->year + 2 }}" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-32">
                        </div>
                        <button onclick="loadSpecificYearlyReport()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                            Tampilkan
                        </button>
                        <button onclick="toggleCustomYear('yearly')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                            Batal
                        </button>
                    </div>
                </div>

                <!-- Yearly Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-blue-600">Pendapatan Tahun Ini</h3>
                                <p class="text-2xl font-bold text-gray-900" id="yearlyIncome">Rp 0</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-xl p-5 border border-green-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-green-100 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-green-600">Reservasi Tahun Ini</h3>
                                <p class="text-2xl font-bold text-gray-900" id="yearlyReservations">0</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 rounded-xl p-5 border border-purple-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-purple-600">Rata-rata Bulanan</h3>
                                <p class="text-2xl font-bold text-gray-900" id="yearlyMonthlyAvg">0</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-yellow-600">Bulan Terbaik</h3>
                                <p class="text-2xl font-bold text-gray-900" id="yearlyBestMonth">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Yearly Chart -->
                <div class="h-80">
                    <canvas id="yearlyChart"></canvas>
                </div>
                
                <!-- Yearly Export Buttons -->
                <div class="mt-6 flex justify-end space-x-4">
                    <form id="yearlyExportExcelForm" method="POST" action="{{ route('admin.reports.export', ['type' => 'yearly']) }}" class="inline">
                        @csrf
                        <input type="hidden" name="report_type" value="yearly">
                        <input type="hidden" id="yearlyDateHidden" name="date" value="{{ \Carbon\Carbon::now()->year }}">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ekspor Excel
                        </button>
                    </form>
                    <form id="yearlyExportPdfForm" method="POST" action="{{ route('admin.reports.export.pdf', ['type' => 'yearly']) }}" class="inline">
                        @csrf
                        <input type="hidden" name="report_type" value="yearly">
                        <input type="hidden" id="yearlyDateHiddenPdf" name="date" value="{{ \Carbon\Carbon::now()->year }}">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ekspor PDF
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Global chart instances
        let dailyChart = null;
        let monthlyChart = null;
        let yearlyChart = null;

        // Toggle custom date visibility for daily report
        function toggleCustomDate(type) {
            const container = document.getElementById(`${type}CustomDateContainer`);
            container.classList.toggle('hidden');
        }

        // Toggle custom month visibility for monthly report
        function toggleCustomMonth(type) {
            const container = document.getElementById(`${type}CustomDateContainer`);
            container.classList.toggle('hidden');
        }

        // Toggle custom year visibility for yearly report
        function toggleCustomYear(type) {
            const container = document.getElementById(`${type}CustomDateContainer`);
            container.classList.toggle('hidden');
        }

        // Load specific daily report based on selected date
        function loadSpecificDailyReport() {
            const selectedDate = document.getElementById('dailyDate').value;
            document.getElementById('dailyDateHidden').value = selectedDate;
            document.getElementById('dailyDateHiddenPdf').value = selectedDate;
            
            loadReport('daily', { date: selectedDate });
        }

        // Load specific monthly report based on selected month
        function loadSpecificMonthlyReport() {
            const selectedMonth = document.getElementById('monthlyDate').value;
            document.getElementById('monthlyDateHidden').value = selectedMonth;
            document.getElementById('monthlyDateHiddenPdf').value = selectedMonth;
            
            loadReport('monthly', { month: selectedMonth });
        }

        // Load specific yearly report based on selected year
        function loadSpecificYearlyReport() {
            const selectedYear = document.getElementById('yearlyDate').value;
            document.getElementById('yearlyDateHidden').value = selectedYear;
            document.getElementById('yearlyDateHiddenPdf').value = selectedYear;
            
            loadReport('yearly', { year: selectedYear });
        }

        // Load report data based on type
        function loadReport(type, params = {}) {
            // Build query parameters
            const urlParams = new URLSearchParams();
            urlParams.append('type', type);
            
            // Add additional parameters if provided
            for (const [key, value] of Object.entries(params)) {
                urlParams.append(key, value);
            }

            // Show loading indicator
            showLoading(type);

            // Fetch report data
            fetch("{{ route('admin.reports.fetch') }}?" + urlParams.toString())
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStats(type, data.stats);
                        updateCharts(type, data.chartData);
                    } else {
                        console.error('Error fetching report data:', data.message);
                        hideLoading(type);
                    }
                })
                .catch(error => {
                    console.error('Error fetching report data:', error);
                    hideLoading(type);
                });
        }

        // Show loading state
        function showLoading(type) {
            document.getElementById(`${type}Income`).textContent = 'Memuat...';
            document.getElementById(`${type}Reservations`).textContent = 'Memuat...';
        }

        // Hide loading state
        function hideLoading(type) {
            // Reset to previous values or keep as is
        }

        // Update stats cards
        function updateStats(type, stats) {
            // Daily stats
            if (type === 'daily') {
                document.getElementById('dailyIncome').textContent = 'Rp ' + (stats.income || 0).toLocaleString();
                document.getElementById('dailyReservations').textContent = stats.reservations || 0;
                document.getElementById('dailyConfirmed').textContent = stats.confirmed || 0;
                document.getElementById('dailyAvgDuration').textContent = stats.avg_duration || '0 jam';
            }
            // Monthly stats
            else if (type === 'monthly') {
                document.getElementById('monthlyIncome').textContent = 'Rp ' + (stats.income || 0).toLocaleString();
                document.getElementById('monthlyReservations').textContent = stats.reservations || 0;
                document.getElementById('monthlyDailyAvg').textContent = stats.daily_avg || 0;
                document.getElementById('monthlyPeakDay').textContent = stats.peak_day || '-';
            }
            // Yearly stats
            else if (type === 'yearly') {
                document.getElementById('yearlyIncome').textContent = 'Rp ' + (stats.income || 0).toLocaleString();
                document.getElementById('yearlyReservations').textContent = stats.reservations || 0;
                document.getElementById('yearlyMonthlyAvg').textContent = stats.monthly_avg || 0;
                document.getElementById('yearlyBestMonth').textContent = stats.best_month || '-';
            }
        }

        // Update charts
        function updateCharts(type, chartData) {
            // Destroy previous chart if exists
            if (type === 'daily' && dailyChart) {
                dailyChart.destroy();
            } else if (type === 'monthly' && monthlyChart) {
                monthlyChart.destroy();
            } else if (type === 'yearly' && yearlyChart) {
                yearlyChart.destroy();
            }

            // Create new chart based on type
            const ctx = document.getElementById(`${type}Chart`).getContext('2d');
            
            if (type === 'daily') {
                dailyChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels || [],
                        datasets: [{
                            label: 'Pendapatan per Jam',
                            data: chartData.income_data || [],
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
                        }
                    }
                });
            } else if (type === 'monthly') {
                monthlyChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels || [],
                        datasets: [{
                            label: 'Pendapatan per Hari',
                            data: chartData.income_data || [],
                            backgroundColor: '#10b981',
                            borderColor: '#059669',
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
                                        return 'Rp ' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            } else if (type === 'yearly') {
                yearlyChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels || [],
                        datasets: [{
                            label: 'Pendapatan per Bulan',
                            data: chartData.income_data || [],
                            borderColor: '#8b5cf6',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
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
                        }
                    }
                });
            }
        }

        // Load initial data for all reports
        document.addEventListener('DOMContentLoaded', function() {
            // Load daily report by default
            loadReport('daily');
            
            // Load monthly report
            setTimeout(() => loadReport('monthly'), 500);
            
            // Load yearly report
            setTimeout(() => loadReport('yearly'), 1000);
        });
    </script>
</body>
</html>
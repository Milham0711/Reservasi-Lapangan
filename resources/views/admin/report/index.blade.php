<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan - SportVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white min-h-screen shadow-lg flex flex-col sticky top-0 h-screen">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-blue-600 text-center">SportVenue</h1>
                <h1 class="ml-3 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full text-center">{{ Auth::user()->nama_232112 }}</h1>
            </div>
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
                    <!-- Laporan Parent Menu -->
                    <div x-data="{ open: true }" class="mb-1">
                        <a href="#" @click="open = !open" class="flex items-center justify-between space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span class="font-semibold">Laporan</span>
                            </div>
                            <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>

                        <!-- Submenu Laporan -->
                        <div x-show="open" x-collapse class="pl-10 mt-1 space-y-1">
                            <a href="{{ route('admin.report.index') }}" class="flex items-center space-x-3 px-4 py-2 {{ request('report_type') == 'general' || !request('report_type') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span>Semua Laporan</span>
                            </a>
                            <a href="{{ route('admin.report.index') }}?report_type=daily" class="flex items-center space-x-3 px-4 py-2 {{ request('report_type') == 'daily' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Laporan Harian</span>
                            </a>
                            <a href="{{ route('admin.report.index') }}?report_type=monthly" class="flex items-center space-x-3 px-4 py-2 {{ request('report_type') == 'monthly' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Laporan Bulanan</span>
                            </a>
                            <a href="{{ route('admin.report.index') }}?report_type=yearly" class="flex items-center space-x-3 px-4 py-2 {{ request('report_type') == 'yearly' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Laporan Tahunan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="flex items-center justify-center border-t border-gray-200 mt-auto py-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition items-center">
                        Logout
                    </button>
                </form>
            </div>
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Laporan</label>
                            <select id="reportType" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="general" {{ request('report_type') == 'general' || !request('report_type') ? 'selected' : '' }}>Semua Laporan</option>
                                <option value="daily" {{ request('report_type') == 'daily' ? 'selected' : '' }}>Laporan Harian</option>
                                <option value="weekly" {{ request('report_type') == 'weekly' ? 'selected' : '' }}>Laporan Mingguan</option>
                                <option value="monthly" {{ request('report_type') == 'monthly' ? 'selected' : '' }}>Laporan Bulanan</option>
                                <option value="yearly" {{ request('report_type') == 'yearly' ? 'selected' : '' }}>Laporan Tahunan</option>
                            </select>
                        </div>
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

            <!-- Notification Container -->
            <div id="notificationContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

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

            <!-- Daily, Monthly, or Yearly Detailed Report Section -->
            @if(request('report_type') == 'daily' || request('report_type') == 'monthly' || request('report_type') == 'yearly')
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            @if(request('report_type') == 'daily') Laporan Harian @elseif(request('report_type') == 'monthly') Laporan Bulanan @else Laporan Tahunan @endif
                        </h2>
                        <p class="text-gray-600">Statistik dan grafik detail untuk laporan @if(request('report_type') == 'daily') harian @elseif(request('report_type') == 'monthly') bulanan @else tahunan @endif</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button onclick="loadSpecificReport()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                            @if(request('report_type') == 'daily') Tampilkan Hari Ini @elseif(request('report_type') == 'monthly') Tampilkan Bulan Ini @else Tampilkan Tahun Ini @endif
                        </button>
                    </div>
                </div>

                <!-- Detailed Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-blue-600">@if(request('report_type') == 'daily') Pendapatan Hari Ini @elseif(request('report_type') == 'monthly') Pendapatan Bulan Ini @else Pendapatan Tahun Ini @endif</h3>
                                <p class="text-2xl font-bold text-gray-900" id="detailedIncome">Rp 0</p>
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
                                <h3 class="text-sm font-medium text-green-600">@if(request('report_type') == 'daily') Reservasi Hari Ini @elseif(request('report_type') == 'monthly') Reservasi Bulan Ini @else Reservasi Tahun Ini @endif</h3>
                                <p class="text-2xl font-bold text-gray-900" id="detailedReservations">0</p>
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
                                <h3 class="text-sm font-medium text-purple-600">@if(request('report_type') == 'daily') Rata-rata Durasi @elseif(request('report_type') == 'monthly') Rata-rata Harian @else Rata-rata Bulanan @endif</h3>
                                <p class="text-2xl font-bold text-gray-900" id="detailedAvg">0</p>
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
                                <h3 class="text-sm font-medium text-yellow-600">@if(request('report_type') == 'daily') Jam Puncak @elseif(request('report_type') == 'monthly') Hari Puncak @else Bulan Puncak @endif</h3>
                                <p class="text-2xl font-bold text-gray-900" id="detailedPeak">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Chart -->
                <div class="h-80">
                    <canvas id="detailedChart"></canvas>
                </div>

                <!-- Detailed Report Table -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Tabel Data Pendapatan @if(request('report_type') == 'daily') Harian @elseif(request('report_type') == 'monthly') Bulanan @else Tahunan @endif
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Reservasi</th>
                                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemesan</th>
                                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lapangan</th>
                                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Lapangan</th>
                                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody id="detailedReportTable" class="divide-y divide-gray-200">
                                <!-- Data will be loaded via AJAX -->
                                <tr>
                                    <td colspan="9" class="px-4 py-4 text-center text-gray-500">Belum ada data. Klik tombol "Tampilkan" untuk memuat data.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Detailed Export Buttons -->
                <div class="mt-6 flex justify-end space-x-4">
                    <form id="detailedExportExcelForm" method="POST" action="{{ route('admin.reports.export', ['type' => request('report_type', 'daily')]) }}" class="inline">
                        @csrf
                        <input type="hidden" name="report_type" value="{{ request('report_type', 'daily') }}">
                        <input type="hidden" id="detailedDate" name="date" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                        <input type="hidden" id="detailedMonth" name="month" value="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                        <input type="hidden" id="detailedYear" name="year" value="{{ \Carbon\Carbon::now()->format('Y') }}">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ekspor Excel
                        </button>
                    </form>
                    <form id="detailedExportPdfForm" method="POST" action="{{ route('admin.reports.export.pdf', ['type' => request('report_type', 'daily')]) }}" class="inline">
                        @csrf
                        <input type="hidden" name="report_type" value="{{ request('report_type', 'daily') }}">
                        <input type="hidden" id="detailedDatePdf" name="date" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                        <input type="hidden" id="detailedMonthPdf" name="month" value="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                        <input type="hidden" id="detailedYearPdf" name="year" value="{{ \Carbon\Carbon::now()->format('Y') }}">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ekspor PDF
                        </button>
                    </form>
                </div>
            </div>
            @endif

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
                            <input type="hidden" id="exportReportType" name="report_type" value="{{ request('report_type', 'general') }}">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg hover:shadow-xl flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Ekspor ke Excel
                            </button>
                        </form>

                        <!-- Export to PDF Button (opens preview first) -->
                        <form id="exportPdfForm" method="POST" action="{{ route('admin.report.preview.pdf') }}" class="inline">
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
        let detailedChart = null;

        // Function to fetch and update report data
        function updateReportData() {
            // Get filter values
            const periodType = document.getElementById('periodType').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const reportType = document.getElementById('reportType').value;

            // Update export form hidden fields
            document.getElementById('exportPeriodType').value = periodType;
            document.getElementById('exportStartDate').value = startDate;
            document.getElementById('exportEndDate').value = endDate;
            document.getElementById('exportReportType').value = reportType;
            document.getElementById('exportPeriodTypePdf').value = periodType;
            document.getElementById('exportStartDatePdf').value = startDate;
            document.getElementById('exportEndDatePdf').value = endDate;
            document.getElementById('exportReportTypePdf').value = reportType;

            // Build query parameters
            const params = new URLSearchParams();
            if (periodType) params.append('period_type', periodType);
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);

            // Show loading notification
            const loadingNotificationId = 'loading-' + Date.now();
            const container = document.getElementById('notificationContainer');
            const loadingNotification = document.createElement('div');
            loadingNotification.id = loadingNotificationId;
            loadingNotification.className = 'notification bg-blue-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center max-w-xs';
            loadingNotification.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memuat data laporan...</span>
            `;
            container.appendChild(loadingNotification);

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

                    // Remove loading notification
                    const loadingNotification = document.getElementById(loadingNotificationId);
                    if (loadingNotification) {
                        loadingNotification.remove();
                    }

                    // If the report type is daily, monthly, or yearly, also update the detailed report section
                    if (reportType === 'daily' || reportType === 'monthly' || reportType === 'yearly') {
                        // For daily, monthly, or yearly reports, load the detailed report data
                        // This will also update the detailed report table
                        setTimeout(loadSpecificReport, 100); // Small delay to ensure state is consistent
                    }

                })
                .catch(error => {
                    // Remove loading notification
                    const loadingNotification = document.getElementById(loadingNotificationId);
                    if (loadingNotification) {
                        loadingNotification.remove();
                    }
                    // Show error notification
                    showNotification('Gagal memuat data laporan. Silakan coba lagi.', 'error');
                    console.error('Error fetching data:', error);
                });
        }

        // Function to load detailed report data
        function loadSpecificReport() {
            const reportType = document.getElementById('reportType').value;

            // Get the dates from the filter fields
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            let date = null;
            let month = null;
            let year = null;

            // Determine parameters based on report type and available filters
            if (reportType === 'daily') {
                // For daily report, use the start date from filter or today if none specified
                date = startDate || new Date().toISOString().split('T')[0];

                // Also update the period type filter to 'daily' to ensure correct data retrieval
                document.getElementById('periodType').value = 'daily';
            } else if (reportType === 'monthly') {
                // For monthly report, extract year-month from start date filter or use current month
                if (startDate) {
                    const start = new Date(startDate);
                    month = start.getFullYear() + '-' + String(start.getMonth() + 1).padStart(2, '0');

                    // Also update the period type filter to 'monthly'
                    document.getElementById('periodType').value = 'monthly';
                } else {
                    month = new Date().getFullYear() + '-' + String(new Date().getMonth() + 1).padStart(2, '0');
                }
            } else if (reportType === 'yearly') {
                // For yearly report, extract year from start date filter or use current year
                if (startDate) {
                    const start = new Date(startDate);
                    year = start.getFullYear().toString();

                    // Also update the period type filter to 'yearly'
                    document.getElementById('periodType').value = 'yearly';
                } else {
                    year = new Date().getFullYear().toString();
                }
            }

            // Update hidden fields for export
            if(date) {
                document.getElementById('detailedDate').value = date;
                document.getElementById('detailedDatePdf').value = date;
            }
            if(month) {
                document.getElementById('detailedMonth').value = month;
                document.getElementById('detailedMonthPdf').value = month;
            }
            if(year) {
                document.getElementById('detailedYear').value = year;
                document.getElementById('detailedYearPdf').value = year;
            }

            // Prepare parameters for fetching report data
            let statsParams = new URLSearchParams();
            statsParams.append('type', reportType);

            // If we have a date range, use it for fetching stats (but still use report type for context)
            if (startDate && endDate) {
                statsParams.append('start_date', startDate);
                statsParams.append('end_date', endDate);
            } else {
                // Otherwise use the specific parameters
                if (reportType === 'daily' && date) {
                    statsParams.append('date', date);
                } else if (reportType === 'monthly' && month) {
                    statsParams.append('month', month);
                } else if (reportType === 'yearly' && year) {
                    statsParams.append('year', year);
                }
            }

            // Fetch specific report data
            fetch(`{{ route('admin.reports.fetch') }}?` + statsParams.toString())
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update stats
                        document.getElementById('detailedIncome').textContent = 'Rp ' + data.stats.income.toLocaleString();
                        document.getElementById('detailedReservations').textContent = data.stats.reservations;
                        document.getElementById('detailedAvg').textContent = data.stats.avg_duration || data.stats.daily_avg || data.stats.monthly_avg;
                        document.getElementById('detailedPeak').textContent = data.stats.confirmed || data.stats.peak_day || data.stats.best_month || '-';

                        // Update chart
                        if (detailedChart) {
                            detailedChart.destroy();
                        }

                        const detailedCtx = document.getElementById('detailedChart').getContext('2d');

                        if (reportType === 'daily') {
                            // Daily: show chart (hourly for single day, daily for date range)
                            detailedChart = new Chart(detailedCtx, {
                                type: 'line',
                                data: {
                                    labels: data.chartData.labels,
                                    datasets: [{
                                        label: 'Pendapatan',
                                        data: data.chartData.income_data,
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
                        } else if (reportType === 'monthly') {
                            // Monthly: show daily chart
                            detailedChart = new Chart(detailedCtx, {
                                type: 'bar',
                                data: {
                                    labels: data.chartData.labels,
                                    datasets: [{
                                        label: 'Pendapatan per Hari',
                                        data: data.chartData.income_data,
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
                        } else if (reportType === 'yearly') {
                            // Yearly: show monthly chart
                            detailedChart = new Chart(detailedCtx, {
                                type: 'line',
                                data: {
                                    labels: data.chartData.labels,
                                    datasets: [{
                                        label: 'Pendapatan per Bulan',
                                        data: data.chartData.income_data,
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

                        // Load detailed report table data
                        // Pass null values so loadDetailedReportTable uses the date range from filters when available
                        loadDetailedReportTable(reportType, null, null, null);
                    }
                })
                .catch(error => console.error('Error fetching detailed report data:', error));
        }

        // Function to load detailed report table
        function loadDetailedReportTable(reportType, date, month, year) {
            // Show loading state
            document.getElementById('detailedReportTable').innerHTML = `
                <tr>
                    <td colspan="9" class="px-4 py-4 text-center text-gray-500">Memuat data...</td>
                </tr>
            `;

            // Get the date range from the filter fields
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            // Prepare the API call based on report type
            let params = new URLSearchParams();

            // If both start and end date are selected, use them instead of report type filters
            if (startDate && endDate) {
                params.append('start_date', startDate);
                params.append('end_date', endDate);
                // Still include the report type for reference
                params.append('type', reportType);
            } else {
                // Otherwise, use the report type specific parameters
                params.append('type', reportType);

                if (reportType === 'daily' && date) {
                    params.append('date', date);
                } else if (reportType === 'monthly' && month) {
                    params.append('month', month);
                } else if (reportType === 'yearly' && year) {
                    params.append('year', year);
                }
            }

            // Fetch detailed report table data from our new endpoint
            fetch(`{{ route('admin.reports.detailed.data') }}?` + params.toString())
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Build table rows
                        if (data.data && data.data.length > 0) {
                            let tableRows = '';
                            data.data.forEach(item => {
                                tableRows += `
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 border-b text-sm">${item.id}</td>
                                        <td class="px-4 py-3 border-b text-sm">${item.user_name}</td>
                                        <td class="px-4 py-3 border-b text-sm">${item.user_email || '-'}</td>
                                        <td class="px-4 py-3 border-b text-sm">${item.lapangan_name}</td>
                                        <td class="px-4 py-3 border-b text-sm">${item.lapangan_jenis || '-'}</td>
                                        <td class="px-4 py-3 border-b text-sm">${item.tanggal_reservasi}</td>
                                        <td class="px-4 py-3 border-b text-sm">${item.waktu_mulai} - ${item.waktu_selesai}</td>
                                        <td class="px-4 py-3 border-b text-sm text-right">${item.formatted_harga}</td>
                                        <td class="px-4 py-3 border-b text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full ${
                                                item.status === 'confirmed' || item.status === 'completed' ?
                                                'bg-green-100 text-green-800' :
                                                item.status === 'pending' ?
                                                'bg-yellow-100 text-yellow-800' :
                                                'bg-red-100 text-red-800'
                                            }">
                                                ${item.status}
                                            </span>
                                        </td>
                                    </tr>
                                `;
                            });

                            document.getElementById('detailedReportTable').innerHTML = tableRows;
                        } else {
                            document.getElementById('detailedReportTable').innerHTML = `
                                <tr>
                                    <td colspan="9" class="px-4 py-4 text-center text-gray-500">Tidak ada data untuk periode ini.</td>
                                </tr>
                            `;
                        }
                    } else {
                        document.getElementById('detailedReportTable').innerHTML = `
                            <tr>
                                <td colspan="9" class="px-4 py-4 text-center text-red-500">Terjadi kesalahan saat memuat data.</td>
                            </tr>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading detailed report table:', error);
                    document.getElementById('detailedReportTable').innerHTML = `
                        <tr>
                            <td colspan="9" class="px-4 py-4 text-center text-red-500">Terjadi kesalahan saat memuat data.</td>
                        </tr>
                    `;
                });
        }

        // Initialize charts on page load

        // Function to show notification
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notificationContainer');
            const notificationId = 'notification-' + Date.now();

            const bgColor = type === 'success' ? 'bg-green-500' : (type === 'error' ? 'bg-red-500' : 'bg-blue-500');
            const icon = type === 'success' ?
                '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                (type === 'error' ?
                '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>' :
                '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>');

            const notification = document.createElement('div');
            notification.id = notificationId;
            notification.className = `notification ${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-center justify-between max-w-xs transform transition-transform duration-300`;
            notification.innerHTML = `
                <div class="flex items-center">
                    ${icon}
                    <span class="ml-2">${message}</span>
                </div>
                <button class="ml-4 text-white hover:text-gray-200 focus:outline-none" onclick="closeNotification('${notificationId}')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            container.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);

            // Auto close after 5 seconds
            setTimeout(() => {
                closeNotification(notificationId);
            }, 5000);
        }

        // Function to close notification
        function closeNotification(notificationId) {
            const notification = document.getElementById(notificationId);
            if (notification) {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }

        // Apply filter button event
        document.getElementById('applyFilter').addEventListener('click', function() {
            updateReportData();
            showNotification('Filter berhasil diterapkan!', 'success');
        });

        updateReportData();
    </script>
</body>
</html>
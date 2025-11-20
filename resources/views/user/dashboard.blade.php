<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SportVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-8">
                    <span class="text-2xl font-bold text-blue-600">SportVenue</span>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('user.dashboard') }}" class="text-blue-600 font-semibold px-3 py-2">Dashboard</a>
                        <a href="{{ route('user.lapangan.index') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2">Lapangan</a>
                        <a href="{{ route('user.reservasi.index') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2">Reservasi Saya</a>
                    </div>
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

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->nama_232112 }}! 👋</h1>
            <p class="text-blue-100">Siap untuk bermain hari ini? Pilih lapangan favoritmu dan booking sekarang!</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Total Reservasi</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalReservasi }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Menunggu Konfirmasi</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $pendingReservasi }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Terkonfirmasi</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $confirmedReservasi }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('user.lapangan.index', ['jenis' => 'futsal']) }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition group">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 p-4 rounded-full group-hover:bg-blue-200 transition">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Booking Futsal</h3>
                        <p class="text-gray-600 text-sm">Lihat & booking lapangan futsal</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('user.lapangan.index', ['jenis' => 'badminton']) }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition group">
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 p-4 rounded-full group-hover:bg-green-200 transition">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Booking Badminton</h3>
                        <p class="text-gray-600 text-sm">Lihat & booking lapangan badminton</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Reservations -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Reservasi Terbaru</h2>
                <a href="{{ route('user.reservasi.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                    Lihat Semua →
                </a>
            </div>

            @if($recentReservasi->count() > 0)
            <div class="space-y-4">
                @foreach($recentReservasi as $reservasi)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800">{{ $reservasi->lapangan->nama_lapangan_232112 }}</h3>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ date('d M Y', strtotime($reservasi->tanggal_reservasi_232112)) }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ date('H:i', strtotime($reservasi->waktu_mulai_232112)) }} - {{ date('H:i', strtotime($reservasi->waktu_selesai_232112)) }}
                                </span>
                                <span class="font-semibold text-blue-600">Rp {{ number_format($reservasi->total_harga_232112, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div>
                            @if($reservasi->status_reservasi_232112 == 'pending')
                                <span class="px-4 py-2 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                            @elseif($reservasi->status_reservasi_232112 == 'confirmed')
                                <span class="px-4 py-2 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Confirmed</span>
                            @elseif($reservasi->status_reservasi_232112 == 'cancelled')
                                <span class="px-4 py-2 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Cancelled</span>
                            @else
                                <span class="px-4 py-2 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">Completed</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-gray-500 mb-4">Belum ada reservasi</p>
                <a href="{{ route('user.lapangan.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                    Booking Sekarang
                </a>
            </div>
            @endif
        </div>
    </main>
</body>
</html>
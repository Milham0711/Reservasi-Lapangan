<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Lapangan - SportVenue</title>
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
                        <a href="{{ route('user.dashboard') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2">Dashboard</a>
                        <a href="{{ route('user.lapangan.index') }}" class="text-blue-600 font-semibold px-3 py-2">Lapangan</a>
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
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pilih Lapangan</h1>
            <p class="text-gray-600">Temukan lapangan terbaik untuk aktivitas olahraga Anda</p>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="GET" action="{{ route('user.lapangan.index') }}" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Lapangan</label>
                    <select name="jenis" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Jenis</option>
                        <option value="futsal" {{ request('jenis') == 'futsal' ? 'selected' : '' }}>Futsal</option>
                        <option value="badminton" {{ request('jenis') == 'badminton' ? 'selected' : '' }}>Badminton</option>
                        <option value="sepak bola" {{ request('jenis') == 'sepak bola' ? 'selected' : '' }}>Sepak Bola</option>
                        <option value="basket" {{ request('jenis') == 'basket' ? 'selected' : '' }}>Basket</option>
                        <option value="voli" {{ request('jenis') == 'voli' ? 'selected' : '' }}>Voli</option>
                        <option value="tenis" {{ request('jenis') == 'tenis' ? 'selected' : '' }}>Tenis</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Filter
                </button>
                <a href="{{ route('user.lapangan.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold transition">
                    Reset
                </a>
            </form>
        </div>

        <!-- Lapangan Grid -->
        @if($lapangan->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($lapangan as $field)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                <!-- Image -->
                <div class="relative h-48 bg-gradient-to-br from-blue-400 to-purple-500 overflow-hidden">
                    @if($field->gambar_232112)
                        <img src="{{ asset($field->gambar_232112) }}" alt="{{ $field->nama_lapangan_232112 }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4">
                        <span class="bg-white px-3 py-1 rounded-full text-xs font-semibold text-gray-800 capitalize">
                            {{ $field->jenis_lapangan_232112 }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $field->nama_lapangan_232112 }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $field->deskripsi_232112 ?? 'Lapangan berkualitas dengan fasilitas lengkap' }}</p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Kapasitas: {{ $field->kapasitas_232112 }} orang
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($field->harga_per_jam_232112, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">per jam</p>
                        </div>
                        <a href="{{ route('user.reservasi.create', $field->lapangan_id_232112) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                            Booking
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $lapangan->links() }}
        </div>
        @else
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Lapangan Tidak Ditemukan</h3>
            <p class="text-gray-500 mb-6">Maaf, tidak ada lapangan yang sesuai dengan filter Anda</p>
            <a href="{{ route('user.lapangan.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                Lihat Semua Lapangan
            </a>
        </div>
        @endif
    </main>
</body>
</html>
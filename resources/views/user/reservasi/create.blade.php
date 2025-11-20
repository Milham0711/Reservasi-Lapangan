<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Lapangan - SportVenue</title>
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
    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('user.lapangan.index') }}" class="text-blue-600 hover:text-blue-700 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Lapangan
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lapangan Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-4">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-500">
                        @if($lapangan->gambar_232112)
                            <img src="{{ asset($lapangan->gambar_232112) }}" alt="{{ $lapangan->nama_lapangan_232112 }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        @endif>
                    </div>
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full mb-3 capitalize">
                            {{ $lapangan->jenis_lapangan_232112 }}
                        </span>
                        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $lapangan->nama_lapangan_232112 }}</h2>
                        <p class="text-gray-600 text-sm mb-4">{{ $lapangan->deskripsi_232112 }}</p>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600 text-sm">Harga per jam</span>
                                <span class="text-xl font-bold text-blue-600">Rp {{ number_format($lapangan->harga_per_jam_232112, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Kapasitas: {{ $lapangan->kapasitas_232112 }} orang
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Form Booking</h1>

                    @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                            </svg>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p class="text-red-700 text-sm">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('user.reservasi.store') }}" id="bookingForm">
                        @csrf
                        <input type="hidden" name="lapangan_id" value="{{ $lapangan->lapangan_id_232112 }}">

                        <!-- Tanggal -->
                        <div class="mb-6">
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Booking <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal" required
                                min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('tanggal') }}">
                        </div>

                        <!-- Waktu Mulai -->
                        <div class="mb-6">
                            <label for="waktu_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="waktu_mulai" id="waktu_mulai" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('waktu_mulai') }}">
                        </div>

                        <!-- Waktu Selesai -->
                        <div class="mb-6">
                            <label for="waktu_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Selesai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="waktu_selesai" id="waktu_selesai" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('waktu_selesai') }}">
                        </div>

                        <!-- Catatan -->
                        <div class="mb-6">
                            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea name="catatan" id="catatan" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Tambahkan catatan jika ada...">{{ old('catatan') }}</textarea>
                        </div>

                        <!-- Estimasi Harga -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 font-medium">Estimasi Total</span>
                                <span class="text-2xl font-bold text-blue-600" id="totalHarga">Rp 0</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">*Harga akan dikonfirmasi setelah booking</p>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="radio" name="metode_pembayaran" value="cash" required
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-3 block text-sm font-medium text-gray-700">Cash (Bayar di Tempat)</span>
                                </label>
                                @if(function_exists('curl_init'))
                                <label class="flex items-center">
                                    <input type="radio" name="metode_pembayaran" value="midtrans" required
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-3 block text-sm font-medium text-gray-700">Pembayaran Online (Midtrans)</span>
                                </label>
                                @endif
                            </div>
                            @error('metode_pembayaran')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            @if(!function_exists('curl_init'))
                            <p class="mt-2 text-sm text-yellow-600">Catatan: Pembayaran online tidak tersedia karena ekstensi cURL tidak ditemukan pada server.</p>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                            Booking Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        const hargaPerJam = {{ $lapangan->harga_per_jam_232112 }};
        const waktuMulai = document.getElementById('waktu_mulai');
        const waktuSelesai = document.getElementById('waktu_selesai');
        const totalHargaEl = document.getElementById('totalHarga');

        function hitungTotal() {
            if (waktuMulai.value && waktuSelesai.value) {
                const mulai = new Date('2000-01-01 ' + waktuMulai.value);
                const selesai = new Date('2000-01-01 ' + waktuSelesai.value);
                const diff = (selesai - mulai) / (1000 * 60 * 60); // dalam jam
                
                if (diff > 0) {
                    const total = diff * hargaPerJam;
                    totalHargaEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
                } else {
                    totalHargaEl.textContent = 'Rp 0';
                }
            }
        }

        waktuMulai.addEventListener('change', hitungTotal);
        waktuSelesai.addEventListener('change', hitungTotal);
    </script>
</body>
</html>
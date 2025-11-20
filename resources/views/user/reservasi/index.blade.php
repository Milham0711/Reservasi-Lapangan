<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reservasi Saya - SportVenue</title>
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
                        <a href="{{ route('user.reservasi.index') }}" class="text-blue-600 font-semibold px-3 py-2">Reservasi Saya</a>
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

    
        <!-- Sidebar -->
        
        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Reservasi Saya</h1>
                <p class="text-gray-600 mt-1">Daftar reservasi yang telah Anda buat</p>
            </div>

            @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- Reservasi Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lapangan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Harga</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Catatan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($reservasi as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $item->reservasi_id_232112 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($item->lapangan->gambar_232112)
                                            <img src="{{ asset($item->lapangan->gambar_232112) }}" alt="{{ $item->lapangan->nama_lapangan_232112 }}" class="w-10 h-10 rounded-lg object-cover mr-3">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $item->lapangan->nama_lapangan_232112 }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->lapangan->jenis_lapangan_232112 }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->tanggal_reservasi_232112)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $item->waktu_mulai_232112 }} - {{ $item->waktu_selesai_232112 }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($item->total_harga_232112, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status_reservasi_232112 == 'pending')
                                        <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                                    @elseif($item->status_reservasi_232112 == 'confirmed')
                                        <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Confirmed</span>
                                    @elseif($item->status_reservasi_232112 == 'cancelled')
                                        <span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Cancelled</span>
                                    @elseif($item->status_reservasi_232112 == 'completed')
                                        <span class="px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">Completed</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $item->catatan_232112 ?: '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->pembayaran)
                                        <div class="mb-2">
                                            <span class="text-xs font-medium text-gray-600">Metode:</span>
                                            <span class="text-sm font-medium">
                                                {{ $item->pembayaran->metode_pembayaran_232112 == 'cash' ? 'Cash' : 'Online' }}
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="text-xs font-medium text-gray-600">Status:</span>
                                            @if($item->pembayaran->status_pembayaran_232112 == 'pending')
                                                <span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded">Pending</span>
                                            @elseif($item->pembayaran->status_pembayaran_232112 == 'paid')
                                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded">Paid</span>
                                            @elseif($item->pembayaran->status_pembayaran_232112 == 'success')
                                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded">Success</span>
                                            @elseif($item->pembayaran->status_pembayaran_232112 == 'failed')
                                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded">Failed</span>
                                            @elseif($item->pembayaran->status_pembayaran_232112 == 'expired')
                                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded">Expired</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded">{{ ucfirst($item->pembayaran->status_pembayaran_232112) }}</span>
                                            @endif
                                        </div>
                                        @if($item->pembayaran->metode_pembayaran_232112 == 'midtrans' && $item->pembayaran->status_pembayaran_232112 == 'pending')
                                            <a href="{{ route('user.reservasi.pay', $item->reservasi_id_232112) }}"
                                               class="mt-1 inline-block bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded transition">
                                                Bayar Sekarang
                                            </a>
                                        @elseif($item->pembayaran->metode_pembayaran_232112 == 'cash')
                                            <span class="text-xs text-gray-600">Bayar di lokasi</span>
                                        @endif
                                        @if($item->pembayaran->status_pembayaran_232112 == 'paid')
                                            <span class="text-xs text-green-600">Sudah dibayar</span>
                                        @elseif($item->pembayaran->status_pembayaran_232112 == 'failed')
                                            <span class="text-xs text-red-600">Pembayaran gagal</span>
                                        @elseif($item->pembayaran->status_pembayaran_232112 == 'expired')
                                            <span class="text-xs text-red-600">Pembayaran kadaluarsa</span>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-500">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada reservasi</h3>
                                    <p class="mt-1 text-sm text-gray-500">Anda belum memiliki reservasi apapun.</p>
                                    <a href="{{ route('user.lapangan.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg hover:shadow-xl">
                                        Buat Reservasi Sekarang
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $reservasi->links() }}
                </div>
            </div>
        </main>
</body>
</html>
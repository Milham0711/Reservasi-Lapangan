@extends('layouts.user-sidebar')

@section('title', 'Pembayaran')
@section('header', 'Pembayaran Reservasi')

@section('content')
    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-md p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Pembayaran Reservasi</h1>
            
            <div class="border border-gray-200 rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Reservasi</h3>
                        <p><span class="font-medium">ID Reservasi:</span> {{ $reservasi->reservasi_id_232112 }}</p>
                        <p><span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi_232112)->format('d M Y') }}</p>
                        <p><span class="font-medium">Waktu:</span> {{ $reservasi->waktu_mulai_232112 }} - {{ $reservasi->waktu_selesai_232112 }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pembayaran</h3>
                        <p><span class="font-medium">Total:</span> <span class="text-xl font-bold text-blue-600">Rp {{ number_format($reservasi->total_harga_232112, 0, ',', '.') }}</span></p>
                        <p><span class="font-medium">Metode:</span> Midtrans</p>
                    </div>
                </div>
            </div>

            @if($snapToken && !str_starts_with($snapToken, 'mock_'))
            <div class="text-center">
                <p class="text-gray-600 mb-6">Silakan selesaikan pembayaran melalui sistem pembayaran yang aman.</p>
                <button id="pay-button" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-8 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                    Bayar Sekarang
                </button>
            </div>
            @else
            <div class="text-center bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <p class="text-yellow-700 font-medium">Sistem pembayaran saat ini sedang dalam mode pengujian</p>
                <p class="text-yellow-600 mt-2">ID Transaksi: {{ $snapToken }}</p>
                <p class="text-gray-600 mt-3">Silakan hubungi administrator atau pilih metode pembayaran cash jika ingin menyelesaikan reservasi ini.</p>
            </div>
            @endif
        </div>
    </main>
    <!-- Include Midtrans Snap JS -->
    @if($snapToken && !str_starts_with($snapToken, 'mock_'))
        @php
            $midtransUrl = config('midtrans.is_production') ? 'https://app.midtrans.com' : 'https://app.sandbox.midtrans.com';
        @endphp
        <script src="{{ $midtransUrl }}/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif

    <script>
        @if($snapToken && !str_starts_with($snapToken, 'mock_'))
        document.getElementById('pay-button').onclick = function() {
            // Check if window.snap exists before calling it
            if (typeof window.snap === 'undefined') {
                alert('Sistem pembayaran belum sepenuhnya dimuat. Silakan refresh halaman.');
                return;
            }

            // Show Snap payment popup
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    fetch('/user/reservasi/{{ $reservasi->reservasi_id_232112 }}/confirm-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            status: 'paid',
                            transaction_result: result
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Status updated:', data);
                        alert("Pembayaran berhasil!");
                        window.location.href = "{{ route('user.reservasi.index') }}";
                    })
                    .catch(error => {
                        console.error('Error updating status:', error);
                        alert("Pembayaran berhasil! Status sedang diperbarui.");
                        window.location.href = "{{ route('user.reservasi.index') }}";
                    });
                },
                onPending: function(result) {
                    // Payment pending - redirect to reservation list
                    alert("Pembayaran sedang diproses, silakan cek status pembayaran nanti.");
                    window.location.href = "{{ route('user.reservasi.index') }}";
                },
                onError: function(result) {
                    // Payment error - redirect to reservation list
                    alert("Pembayaran gagal, silakan coba kembali.");
                    window.location.href = "{{ route('user.reservasi.index') }}";
                },
                onClose: function() {
                    // Payment window closed - redirect to reservation list
                    alert("Anda menutup jendela pembayaran. Silakan lanjutkan pembayaran dari halaman reservasi.");
                    window.location.href = "{{ route('user.reservasi.index') }}";
                }
            });
        };
        @endif
    </script>
@endsection
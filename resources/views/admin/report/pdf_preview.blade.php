<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Laporan Reservasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-section, .print-section * {
                visibility: visible;
            }
            .print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Preview Header -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Preview Laporan Reservasi</h1>
                    <p class="text-gray-600 mt-1">Pratinjau sebelum mengunduh PDF</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <button onclick="window.history.back()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                        Kembali
                    </button>
                    <button id="downloadPdfBtn" class="hidden bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Unduh PDF
                    </button>
                    <button id="printBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak
                    </button>
                </div>
            </div>
        </div>

        <!-- PDF Preview Content -->
        <div id="pdfContent" class="print-section">
            <div class="bg-white rounded-xl shadow-md p-8">
                <div class="header text-center mb-6">
                    <div class="header-logo flex justify-center mb-4">
                        <img src="{{ asset('images/logo/logo.png') }}" alt="SportVenue Logo" class="h-10">
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Laporan Reservasi Lapangan</h1>
                    <p class="text-gray-600 mt-2">Periode: {{ $periodeInfo ?? 'Semua Waktu' }}</p>
                    <p class="text-gray-700 font-semibold mt-1">Total Pendapatan: Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
                    <p class="text-gray-500 text-sm mt-1">Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-semibold text-gray-700">ID Reservasi</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-semibold text-gray-700">Nama Pemesan</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-semibold text-gray-700">Email Pemesan</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-semibold text-gray-700">Nama Lapangan</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-semibold text-gray-700">Jenis Lapangan</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-semibold text-gray-700">Waktu</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-semibold text-gray-700">Total Harga</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="border border-gray-300 px-3 py-2 text-left text-sm font-semibold text-gray-700">Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservasi as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-3 py-2 text-sm">{{ $item->reservasi_id_232112 }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-sm">{{ $item->user->nama_232112 }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-sm">{{ $item->user->email_232112 }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-sm">{{ $item->lapangan->nama_lapangan_232112 }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-sm">{{ $item->lapangan->jenis_lapangan_232112 }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-sm">{{ \Carbon\Carbon::parse($item->tanggal_reservasi_232112)->format('d/m/Y') }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-sm">{{ $item->waktu_mulai_232112 }} - {{ $item->waktu_selesai_232112 }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-sm">Rp {{ number_format($item->total_harga_232112, 0, ',', '.') }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-sm">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($item->status_reservasi_232112 == 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($item->status_reservasi_232112 == 'completed') bg-green-100 text-green-800
                                        @elseif($item->status_reservasi_232112 == 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $item->status_reservasi_232112 }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-sm">{{ \Carbon\Carbon::parse($item->created_at_232112)->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="border border-gray-300 px-3 py-4 text-center text-gray-500">Tidak ada data reservasi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="footer mt-8 text-center text-gray-500 text-sm">
                    <p>Laporan Reservasi Lapangan - SportVenue</p>
                    <p class="mt-1">Dicetak oleh: {{ auth()->user()->nama_232112 ?? 'Admin' }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to download as PDF - submit form to generate PDF
        document.getElementById('downloadPdfBtn').addEventListener('click', function() {
            // Create a form to submit the request with the same parameters
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.report.export.pdf") }}';

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            // Add the same filter parameters
            const periodTypeInput = document.createElement('input');
            periodTypeInput.type = 'hidden';
            periodTypeInput.name = 'period_type';
            periodTypeInput.value = '{{ $periodType }}';
            form.appendChild(periodTypeInput);

            if('{{ $startDate }}' !== '') {
                const startDateInput = document.createElement('input');
                startDateInput.type = 'hidden';
                startDateInput.name = 'start_date';
                startDateInput.value = '{{ $startDate }}';
                form.appendChild(startDateInput);
            }

            if('{{ $endDate }}' !== '') {
                const endDateInput = document.createElement('input');
                endDateInput.type = 'hidden';
                endDateInput.name = 'end_date';
                endDateInput.value = '{{ $endDate }}';
                form.appendChild(endDateInput);
            }

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        });

        // Print function
        document.getElementById('printBtn').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>
</html>
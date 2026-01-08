<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Reservasi</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0.5in;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-logo {
            text-align: center;
            margin-bottom: 10px;
        }
        .header-logo img {
            height: 40px;
            margin-bottom: 5px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-logo">
            <img src="data:image/png;base64,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" alt="SportVenue Logo" style="height: 40px;">
        </div>
        <h1>Laporan Reservasi Lapangan</h1>
        <p>Periode: {{ $periodeInfo ?? 'Semua Waktu' }}</p>
        <p>Total Pendapatan: Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
        <p>Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Reservasi</th>
                <th>Nama Pemesan</th>
                <th>Email Pemesan</th>
                <th>Nama Lapangan</th>
                <th>Jenis Lapangan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservasi as $item)
            <tr>
                <td>{{ $item->reservasi_id_232112 }}</td>
                <td>{{ $item->user->nama_232112 }}</td>
                <td>{{ $item->user->email_232112 }}</td>
                <td>{{ $item->lapangan->nama_lapangan_232112 }}</td>
                <td>{{ $item->lapangan->jenis_lapangan_232112 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_reservasi_232112)->format('d/m/Y') }}</td>
                <td>{{ $item->waktu_mulai_232112 }} - {{ $item->waktu_selesai_232112 }}</td>
                <td>Rp {{ number_format($item->total_harga_232112, 0, ',', '.') }}</td>
                <td>{{ $item->status_reservasi_232112 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at_232112)->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Laporan Reservasi Lapangan - SportVenue
    </div>
</body>
</html>
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
        <h1>Laporan Reservasi Lapangan</h1>
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
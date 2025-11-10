<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Detail Lokasi - {{ $location->name ?? 'Lapangan' }}</title>
    <style>
        body{font-family:Segoe UI,Roboto,Arial; background:#f7fafc; padding:24px}
        .card{max-width:900px;margin:0 auto;background:#fff;padding:20px;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,0.06)}
        .hero img{width:100%;height:320px;object-fit:cover;border-radius:8px}
        .meta{display:flex;justify-content:space-between;align-items:center;margin-top:12px}
        .price{font-weight:700;color:#2d3748}
        a.btn{display:inline-block;padding:8px 14px;border-radius:8px;background:#667eea;color:#fff;text-decoration:none}
    </style>
</head>
<body>
    <div class="card">
        <div class="hero">
            <img src="{{ isset($location->image) && $location->image ? asset($location->image) : asset('images/placeholder-field.svg') }}" alt="{{ $location->name ?? 'Lapangan' }}">
        </div>
        <h1 style="margin-top:12px">{{ $location->name ?? 'Nama Lapangan' }}</h1>
        <div class="meta">
            <div class="type">Tipe: {{ $location->type ?? ($location->jenis_lapangan_232112 ?? '-') }}</div>
            <div class="price">Harga: Rp {{ number_format($location->price ?? ($location->harga_per_jam_232112 ?? 0), 0, ',', '.') }} / jam</div>
        </div>
        <p style="margin-top:12px;color:#4a5568">{{ $location->description ?? ($location->deskripsi_232112 ?? 'Tidak ada deskripsi') }}</p>
        <div style="margin-top:18px">
            <form action="{{ route('reservations.create') }}" method="get" style="display:inline;margin-right:8px;">
                <input type="hidden" name="lapangan_id" value="{{ $location->id }}">
                <button type="submit" class="btn">📅 Buat Reservasi</button>
            </form>
            <a href="{{ url()->previous() ?: route('user.dashboard') }}" class="btn">Kembali</a>
        </div>
    </div>
</body>
</html>

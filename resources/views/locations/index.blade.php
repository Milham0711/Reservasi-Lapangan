<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Daftar Lapangan</title>
    <style>
        body{font-family:Segoe UI,Roboto,Arial; background:#f7fafc; padding:24px}
        .wrap{max-width:1000px;margin:0 auto}
        .list{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px}
        .card{background:#fff;padding:12px;border-radius:10px;box-shadow:0 6px 20px rgba(0,0,0,0.06)}
        .hero{height:160px;overflow:hidden;border-radius:8px}
        .hero img{width:100%;height:100%;object-fit:cover}
        .meta{display:flex;justify-content:space-between;align-items:center;margin-top:8px}
        a.btn{display:inline-block;padding:8px 12px;border-radius:8px;background:#667eea;color:#fff;text-decoration:none}
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Daftar Lapangan {{ $filter ? ' - ' . ucfirst($filter) : '' }}</h1>
        <p><a href="{{ route('user.dashboard') }}">← Kembali ke Dashboard</a></p>
        @if(count($locations) === 0)
            <div class="card">Belum ada lapangan ditemukan untuk filter ini.</div>
        @else
        <div class="list">
            @foreach($locations as $loc)
            <div class="card">
                <div class="hero"><img src="{{ isset($loc->image) && $loc->image ? asset($loc->image) : asset('images/placeholder-field.svg') }}" alt="{{ $loc->name }}"></div>
                <h3 style="margin-top:8px">{{ $loc->name }}</h3>
                <div class="meta">
                    <div class="type">{{ $loc->type }}</div>
                    <div class="price">Rp {{ number_format($loc->price ?? 0,0,',','.') }}/jam</div>
                </div>
                <p style="margin-top:8px;color:#4a5568">{{ Str::limit($loc->description ?? '', 120) }}</p>
                <div style="margin-top:10px"><a class="btn" href="{{ route('locations.show', ['id' => $loc->id]) }}">Lihat</a></div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</body>
</html>

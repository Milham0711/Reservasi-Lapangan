<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member - SportVenue</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="container">

        <nav class="navbar">
            <div class="navbar-brand">
                <h1 style="font-size:1.25rem; margin:0;">SportVenue</h1>
            </div>
            <div class="user-info" style="display:flex; align-items:center; gap:12px;">
                {{-- mobile hamburger (placeholder) --}}
                <button id="navToggle" style="display:none; background:transparent; border:none; font-size:1.25rem; cursor:pointer;">☰</button>

                @if(isset($user) && is_array($user))
                    <div style="position:relative;">
                        <button id="userMenuBtn" style="background:transparent; border:none; cursor:pointer; font-weight:700;">{{ $user['name'] }} ▾</button>
                        <div id="userMenu" class="dropdown-menu" style="display:none; position:absolute; right:0; top:36px; background:white; border-radius:8px; box-shadow:0 8px 24px rgba(0,0,0,0.12); overflow:hidden;">
                            <a href="#" style="display:block;padding:8px 12px;color:#2d3748;text-decoration:none;">Profile</a>
                            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" style="display:block;width:100%;text-align:left;padding:8px 12px;border:none;background:transparent;cursor:pointer;">Logout</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </nav>

        <header class="dashboard-header">
            <h1>Selamat datang di SportVenue</h1>
            <p>Temukan dan pesan lapangan olahraga terdekat dengan mudah.</p>
        </header>

        {{-- Hero slider: shows all locations on top --}}
        @if(isset($locations) && count($locations) > 0)
        <div class="card hero-bleed" style="margin-bottom:1.5rem; padding:0;">
            <div class="slider" role="region" aria-label="Slider kategori lapangan" tabindex="0">
                <button class="slider-btn prev" aria-label="Sebelumnya">‹</button>
                <div class="slides" role="list" id="heroSlides">
                    @php $groups = $locations->groupBy('type'); @endphp
                    @foreach($groups as $type => $items)
                    <div class="slide" role="listitem" aria-hidden="true">
                            @php
                                $bannerImages = [
                                    'futsal' => asset('images/banners/futsal-banner.jpg'),
                                    'badminton' => asset('images/banners/badminton-banner.jpg'),
                                    'basket' => asset('images/banners/sports-banner.jpg'),
                                    'tennis' => asset('images/banners/sports-banner.jpg'),
                                    'voli' => asset('images/banners/sports-banner.jpg')
                                ];
                                $banner = $bannerImages[$type] ?? asset('images/banners/sports-banner.jpg');
                            @endphp
                            <a href="{{ route('locations.index', ['type' => $type]) }}" class="slide-link" style="display:block; text-decoration:none; color:inherit;">
                                <div class="slide-banner" style="background-image:url('{{ $banner }}')" aria-hidden="true"></div>
                            </a>
                            <div style="padding:1rem; color:#2d3748;">
                                <h3 style="margin-bottom:0.5rem;">{{ ucfirst($type) }}</h3>
                                <div style="color:#718096; font-size:0.95rem; margin-bottom:0.75rem;">{{ $items->count() }} lokasi</div>
                            </div>
                        <div class="category-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:12px; padding:0 1rem 1rem 1rem;">
                            @foreach($items as $loc)
                            <a href="{{ route('locations.show', ['id' => $loc->id]) }}" class="cat-card" style="background:#fff;border-radius:10px;overflow:hidden;text-decoration:none;color:inherit; display:block;">
                                <div class="cat-title">{{ $loc->name }}</div>
                                <div class="cat-sub">Rp {{ number_format($loc->price ?? 0, 0, ',', '.') }}/jam</div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    {{-- Additional static slide for demonstration --}}
                    <div class="slide" role="listitem" aria-hidden="true">
                        <a href="{{ route('reservations.create') }}" class="slide-link" style="display:block; text-decoration:none; color:inherit;">
                            <div class="slide-banner" style="background-image:url('{{ asset('images/banners/sports-banner.jpg') }}')" aria-hidden="true"></div>
                        </a>
                        <div style="padding:1rem; color:#2d3748;">
                            <h3 style="margin-bottom:0.5rem;">Promo Spesial</h3>
                            <div style="color:#718096; font-size:0.95rem; margin-bottom:0.75rem;">Diskon 20% untuk member baru</div>
                        </div>
                        <div class="category-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:12px; padding:0 1rem 1rem 1rem;">
                            <a href="#" class="cat-card" style="background:#fff;border-radius:10px;overflow:hidden;text-decoration:none;color:inherit; display:block;">
                                <div class="cat-title">Lapangan Futsal</div>
                                <div class="cat-sub">Rp 75.000/jam</div>
                            </a>
                            <a href="#" class="cat-card" style="background:#fff;border-radius:10px;overflow:hidden;text-decoration:none;color:inherit; display:block;">
                                <div class="cat-title">Lapangan Badminton</div>
                                <div class="cat-sub">Rp 80.000/jam</div>
                            </a>
                        </div>
                    </div>
                </div>
                <button class="slider-btn next" aria-label="Selanjutnya (kategori)" title="Selanjutnya (kategori)" aria-controls="heroSlides">›</button>
            </div>
            <div class="slider-dots" role="tablist" aria-label="Pilih kategori"></div>
            <div id="sliderAnnouncement" class="sr-only" aria-live="polite"></div>
        </div>
        @endif

        

        <div class="sports-grid">
            <div class="card">
                <div class="sport-header">
                    <div class="sport-icon futsal-icon">⚽</div>
                    <div>
                        <div class="sport-title">Lapangan Futsal</div>
                        <div class="sport-subtitle">Lapangan indoor berkualitas</div>
                    </div>
                </div>
                <div class="field-list">
                    <div class="field-item">
                        <div class="field-info">
                            <div class="field-name">Lapangan Vinyl Futsal</div>
                            <div class="field-details">Ukuran: 25x15m • Rp 50.000/jam</div>
                        </div>
                        <div class="field-status status-available">Tersedia</div>
                    </div>
                    <div class="field-item">
                        <div class="field-info">
                            <div class="field-name">Lapangan Sintetis Futsal</div>
                            <div class="field-details">Ukuran: 25x15m • Rp 40.000/jam</div>
                        </div>
                        <div class="field-status status-available">Tersedia</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="sport-header">
                    <div class="sport-icon badminton-icon">🏸</div>
                    <div>
                        <div class="sport-title">Lapangan Badminton</div>
                        <div class="sport-subtitle">Lapangan standar nasional</div>
                    </div>
                </div>
                <div class="field-list">
                    <div class="field-item">
                        <div class="field-info">
                            <div class="field-name">Badminton 1</div>
                            <div class="field-details">Indoor • Rp 80.000/jam</div>
                        </div>
                        <div class="field-status status-available">Tersedia</div>
                    </div>
                    <div class="field-item">
                        <div class="field-info">
                            <div class="field-name">Badminton 2</div>
                            <div class="field-details">Indoor • Rp 80.000/jam</div>
                        </div>
                        <div class="field-status status-available">Tersedia</div>
                    </div>
                    <div class="field-item">
                        <div class="field-info">
                            <div class="field-name">Badminton 3</div>
                            <div class="field-details">Indoor • Rp 80.000/jam</div>
                        </div>
                        <div class="field-status status-booked">Booked</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Per-sport sliders removed; only the main hero slider remains above --}}

        <div class="card">
            <h2 class="section-title">JADWAL RESERVASI</h2>
            
            <div class="reservation-grid">
                <div class="reservation-card">
                    <div class="reservation-sport">Futsal Vinyl</div>
                    <div class="reservation-details">
                        📅 25 Okt 2024<br>⏰ 19:00 - 21:00<br>💰 Rp 100.000
                    </div>
                    <span class="reservation-status">Confirmed</span>
                </div>
                
                <div class="reservation-card">
                    <div class="reservation-sport">Badminton 2</div>
                    <div class="reservation-details">
                        📅 26 Okt 2024<br>⏰ 16:00 - 17:00<br>💰 Rp 80.000
                    </div>
                    <span class="reservation-status">Pending</span>
                </div>
            </div>

            <div style="text-align: center; padding: 2rem; color: #718096;">
                <p>Belum ada reservasi? Yuk booking lapangan favorit Anda!</p>
            </div>
            
            <div class="action-buttons">
                <a href="{{ route('reservations.create') }}" class="btn btn-primary">📅 Buat Reservasi Baru</a>
                <a href="{{ route('reservations.index') }}" class="btn btn-secondary">📋 Lihat Semua Reservasi</a>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
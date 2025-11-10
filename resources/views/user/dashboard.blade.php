<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member - SportVenue</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        
        .navbar { 
            background: rgba(255, 255, 255, 0.95); padding: 1rem 2rem; border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); margin-bottom: 2rem;
            display: flex; justify-content: space-between; align-items: center;
        }
        .navbar-brand h1 { color: #2d3748; font-size: 1.5rem; font-weight: 700; }
        .user-info { text-align: right; color: #4a5568; }
        .user-info .welcome { font-weight: 600; color: #2d3748; }
        
        .dashboard-header { text-align: center; margin-bottom: 3rem; color: white; }
        .dashboard-header h1 { font-size: 2.5rem; margin-bottom: 0.5rem; font-weight: 700; }
        .dashboard-header p { font-size: 1.1rem; opacity: 0.9; }
        
        .card { 
            background: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15); }
        
        .sports-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 3rem; }
        
        .sport-header { display: flex; align-items: center; margin-bottom: 1.5rem; }
        .sport-icon { 
            width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; 
            justify-content: center; margin-right: 1rem; font-size: 1.5rem; color: white;
        }
        .futsal-icon { background: linear-gradient(135deg, #ff6b6b, #ee5a52); }
        .badminton-icon { background: linear-gradient(135deg, #4ecdc4, #44a08d); }
        .sport-title { font-size: 1.5rem; font-weight: 700; color: #2d3748; }
        .sport-subtitle { color: #718096; font-size: 0.9rem; }
        
        .field-list { margin-top: 1rem; }
        .field-item { 
            display: flex; justify-content: space-between; align-items: center; padding: 1rem;
            background: #f7fafc; border-radius: 10px; margin-bottom: 0.5rem; border-left: 4px solid #4299e1;
        }
        .field-name { font-weight: 600; color: #2d3748; margin-bottom: 0.25rem; }
        .field-details { font-size: 0.85rem; color: #718096; }
        .field-status { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .status-available { background: #c6f6d5; color: #276749; }
        .status-booked { background: #fed7d7; color: #c53030; }
        
        .section-title { font-size: 1.5rem; font-weight: 700; color: #2d3748; margin-bottom: 1.5rem; text-align: center; }
        .reservation-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
        .reservation-card { background: #f7fafc; padding: 1.5rem; border-radius: 15px; border-left: 4px solid #4299e1; }
        .reservation-sport { font-weight: 600; color: #2d3748; margin-bottom: 0.5rem; }
        .reservation-details { color: #718096; font-size: 0.9rem; margin-bottom: 1rem; }
        .reservation-status { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; background: #bee3f8; color: #2c5282; }
        
        .action-buttons { display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; }
        .btn { 
            padding: 12px 24px; border: none; border-radius: 10px; font-weight: 600; text-decoration: none;
            display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; cursor: pointer;
        }
        .btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
        .btn-secondary { background: rgba(255, 255, 255, 0.2); color: white; border: 2px solid rgba(255, 255, 255, 0.3); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); }
        
        .alert { padding: 1rem; border-radius: 10px; margin-bottom: 1rem; text-align: center; }
        .alert-info { background: rgba(144, 205, 244, 0.2); color: #2c5282; border: 1px solid #bee3f8; }
        
        @media (max-width: 768px) {
            .sports-grid, .reservation-grid { grid-template-columns: 1fr; }
            .navbar { flex-direction: column; text-align: center; gap: 1rem; }
            .user-info { text-align: center; }
            .action-buttons { flex-direction: column; }
        }
        /* Slider styles for lokasi lapangan */
        .slider { position: relative; overflow: hidden; border-radius: 12px; }
        .slides { display: flex; transition: transform 0.5s ease; will-change: transform; }
        .slide { min-width: 100%; box-sizing: border-box; position: relative; color: #2d3748; }
        .slide img { width: 100%; height: 320px; object-fit: cover; display: block; border-radius: 10px; }
        .slide-caption { position: absolute; left: 20px; bottom: 20px; background: rgba(0,0,0,0.45); color: white; padding: 0.6rem 0.9rem; border-radius: 8px; backdrop-filter: blur(4px); }
        .slide-title { font-weight: 700; font-size: 1.05rem; }
        .slide-sub { font-size: 0.85rem; opacity: 0.95; }
        .slider-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.45); color: white; border: none; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1.35rem; }
        .slider-btn.prev { left: 12px; }
        .slider-btn.next { right: 12px; }
        .slider-dots { display: flex; gap: 8px; justify-content: center; margin-top: 12px; }
        .slider-dots button { width: 10px; height: 10px; border-radius: 50%; border: none; background: rgba(0,0,0,0.2); cursor: pointer; }
        .slider-dots button.active { background: #2d3748; }
        @media (max-width: 480px) {
            .slide img { height: 200px; }
            .slider-btn { width: 36px; height: 36px; font-size: 1.1rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
    <div class="navbar-brand"><h1>🏟️ SportVenue</h1></div>
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        @include('components.notification-bell')
        <div class="user-info">
            <div class="welcome">Selamat Datang, {{ $user['name'] }}!</div>
                <div>{{ $user['email'] }}</div>
            </div>
        </div>
    </nav>

        @if(isset($user['is_temporary']) && $user['is_temporary'])
        <div class="alert alert-info">
            <strong>Info:</strong> Ini adalah akun temporary. Data registrasi Anda tidak disimpan secara permanen.
        </div>
        @endif

        <div class="dashboard-header">
            <h1>LAPANGAN OLAHRAGA</h1>
            <p>Pilih lapangan favorit Anda dan lakukan reservasi</p>
        </div>

        <!-- Slider lokasi lapangan -->
        @if(isset($locations) && count($locations) > 0)
        <div class="card" style="margin-bottom: 2rem;">
            <h2 class="section-title" style="color: #2d3748;">Lokasi Lapangan</h2>
            <div class="slider" id="location-slider">
                <button class="slider-btn prev" aria-label="Sebelumnya">‹</button>
                <div class="slides">
                    @foreach($locations as $loc)
                    <div class="slide">
                        <a href="{{ route(isset($loc->id) ? 'locations.show' : 'locations.show', ['id' => $loc->id ?? ($loc['id'] ?? null)]) }}">
                            <img src="{{ isset($loc->image) && $loc->image ? asset($loc->image) : asset('images/placeholder-field.jpg') }}" alt="{{ $loc->name ?? ($loc['name'] ?? 'Lapangan') }}">
                        </a>
                        <div class="slide-caption">
                            <div class="slide-title">{{ $loc->name ?? ($loc['name'] ?? 'Nama Lapangan') }}</div>
                            @if(isset($loc->description) || isset($loc['description']))
                            <div class="slide-sub">{{ $loc->description ?? ($loc['description'] ?? '') }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="slider-btn next" aria-label="Selanjutnya">›</button>
            </div>
            <div class="slider-dots" id="location-slider-dots" aria-hidden="false"></div>
        </div>
        @else
        <div class="card" style="margin-bottom: 2rem;">
            <h2 class="section-title" style="color: #2d3748;">Lokasi Lapangan</h2>
            <div style="text-align:center; color:#718096; padding:1.5rem;">Belum ada lokasi lapangan yang tersedia.</div>
        </div>
        @endif

    <div class="card" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; margin-bottom: 2rem;">
        <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 1rem; align-items: center;">
            <div style="font-size: 2.5rem;">🕒</div>
        <div>
            <div style="font-weight: 700; font-size: 1.3rem; margin-bottom: 0.25rem;">Jam Operasional SportVenue</div>
            <div style="opacity: 0.9; font-size: 0.95rem;">Buka setiap hari untuk melayani aktivitas olahraga Anda</div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem;">08:00 - 23:00</div>
            <div style="opacity: 0.8; font-size: 0.9rem;">Last Order: 21:00 WIB</div>
        </div>
    </div>
</div>

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
    
    <script>
        function showComingSoon() {
            alert('Fitur ini sedang dalam pengembangan.');
            return false;
        }
    </script>
    <script>
        (function(){
            const slider = document.getElementById('location-slider');
            if (!slider) return;

            const slidesWrap = slider.querySelector('.slides');
            const slides = Array.from(slidesWrap.children);
            const prevBtn = slider.querySelector('.slider-btn.prev');
            const nextBtn = slider.querySelector('.slider-btn.next');
            const dotsContainer = document.getElementById('location-slider-dots');
            let index = 0;
            let autoplayInterval = null;
            const INTERVAL_MS = 4500;

            function goTo(i){
                index = (i + slides.length) % slides.length;
                slidesWrap.style.transform = `translateX(-${index * 100}%)`;
                updateDots();
            }

            function next(){ goTo(index + 1); }
            function prev(){ goTo(index - 1); }

            function createDots(){
                dotsContainer.innerHTML = '';
                slides.forEach((_, i) => {
                    const btn = document.createElement('button');
                    btn.setAttribute('aria-label', 'Slide ' + (i+1));
                    btn.addEventListener('click', () => { goTo(i); resetAutoplay(); });
                    dotsContainer.appendChild(btn);
                });
                updateDots();
            }

            function updateDots(){
                Array.from(dotsContainer.children).forEach((b, i) => {
                    b.classList.toggle('active', i === index);
                });
            }

            function startAutoplay(){
                if (autoplayInterval) clearInterval(autoplayInterval);
                autoplayInterval = setInterval(next, INTERVAL_MS);
            }
            function stopAutoplay(){ if (autoplayInterval) { clearInterval(autoplayInterval); autoplayInterval = null; } }
            function resetAutoplay(){ stopAutoplay(); startAutoplay(); }

            // Wire controls
            if (nextBtn) nextBtn.addEventListener('click', () => { next(); resetAutoplay(); });
            if (prevBtn) prevBtn.addEventListener('click', () => { prev(); resetAutoplay(); });

            // Pause on hover
            slider.addEventListener('mouseenter', stopAutoplay);
            slider.addEventListener('mouseleave', startAutoplay);

            // Keyboard
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowRight') { next(); resetAutoplay(); }
                if (e.key === 'ArrowLeft') { prev(); resetAutoplay(); }
            });

            // Init
            createDots();
            if (slides.length <= 1) {
                // hide controls if only one slide
                prevBtn && (prevBtn.style.display = 'none');
                nextBtn && (nextBtn.style.display = 'none');
            } else {
                startAutoplay();
            }

            // Ensure starting at 0
            goTo(0);
        })();
    </script>
</body>
</html>
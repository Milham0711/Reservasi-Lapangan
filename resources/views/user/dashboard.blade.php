@extends('layouts.user-sidebar')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->nama_232112 }}! 👋</h1>
            <p class="text-blue-100">Siap untuk bermain hari ini? Pilih lapangan favoritmu dan booking sekarang!</p>
        </div>

        <!-- Image Slider -->
        <div class="mb-8">
            <div class="relative overflow-hidden rounded-2xl shadow-lg">
                <!-- Slider Container -->
                <div class="relative h-80 md:h-[450px] lg:h-[670px] overflow-hidden">
                    <div class="absolute inset-0 flex transition-transform duration-500 ease-in-out" id="slider-container">
                        <div class="w-full h-full flex-shrink-0">
                            <img src="https://isibangunan.com/wp-content/uploads/2017/12/palau-blaugrana-scaled.jpg" 
                                alt="Sport Facility 1" class="w-full h-full object-cover">
                        </div>
                        <div class="w-full h-full flex-shrink-0">
                            <img src="https://mediaini.com/wp-content/uploads/2022/02/daftar-lapangan-tenis-di-Bandung-by-Pixabay-640x375.jpg" 
                                alt="Futsal Field" class="w-full h-full object-cover">
                        </div>
                        <div class="w-full h-full flex-shrink-0">
                            <img src="https://asset.ayo.co.id/image/venue/170987582950787.image_cropper_1709875801634_large.jpg" 
                                alt="Badminton Court" class="w-full h-full object-cover">
                        </div>
                        <div class="w-full h-full flex-shrink-0">
                            <img src="https://lifetimedesign.co/wp-content/uploads/2025/06/Lapangan-Padel-1024x555.png" 
                                alt="Badminton Court" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Slider Indicators -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <button class="slider-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition"></button>
                        <button class="slider-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition"></button>
                        <button class="slider-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition"></button>
                        <button class="slider-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition"></button>
                    </div>

                    <!-- Navigation Arrows -->
                    <button id="prev-btn" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-30 hover:bg-opacity-50 text-white rounded-full w-10 h-10 flex items-center justify-center transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button id="next-btn" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-30 hover:bg-opacity-50 text-white rounded-full w-10 h-10 flex items-center justify-center transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Total Reservasi</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalReservasi }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Menunggu Konfirmasi</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $pendingReservasi }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Terkonfirmasi</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $confirmedReservasi }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('user.lapangan.index', ['jenis' => 'futsal']) }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition group">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 p-4 rounded-full group-hover:bg-blue-200 transition">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Booking Futsal</h3>
                        <p class="text-gray-600 text-sm">Lihat & booking lapangan futsal</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('user.lapangan.index', ['jenis' => 'badminton']) }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition group">
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 p-4 rounded-full group-hover:bg-green-200 transition">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Booking Badminton</h3>
                        <p class="text-gray-600 text-sm">Lihat & booking lapangan badminton</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('user.lapangan.index', ['jenis' => 'tenis']) }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition group">
                <div class="flex items-center space-x-4">
                    <div class="bg-purple-100 p-4 rounded-full group-hover:bg-purple-200 transition">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.004a2.889 2.889 0 00-3.985-.009 2.889 2.889 0 00-.01 3.993zM3.75 21V4.125C3.75 3.504 4.254 3 4.875 3h14.25c.621 0 1.125.504 1.125 1.125v16.875H3.75z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Booking Tenis</h3>
                        <p class="text-gray-600 text-sm">Lihat & booking lapangan tenis</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('user.lapangan.index', ['jenis' => 'padel']) }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition group">
                <div class="flex items-center space-x-4">
                    <div class="bg-yellow-100 p-4 rounded-full group-hover:bg-yellow-200 transition">
                        <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Booking Padel</h3>
                        <p class="text-gray-600 text-sm">Lihat & booking lapangan padel</p>
                    </div>
                </div>
            </a>




        </div>

        <!-- Recent Reservations -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Reservasi Terbaru</h2>
                <a href="{{ route('user.reservasi.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                    Lihat Semua →
                </a>
            </div>

            @if($recentReservasi->count() > 0)
            <div class="space-y-4">
                @foreach($recentReservasi as $reservasi)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800">{{ $reservasi->lapangan->nama_lapangan_232112 }}</h3>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ date('d M Y', strtotime($reservasi->tanggal_reservasi_232112)) }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ date('H:i', strtotime($reservasi->waktu_mulai_232112)) }} - {{ date('H:i', strtotime($reservasi->waktu_selesai_232112)) }}
                                </span>
                                <span class="font-semibold text-blue-600">Rp {{ number_format($reservasi->total_harga_232112, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div>
                            @if($reservasi->status_reservasi_232112 == 'pending')
                                <span class="px-4 py-2 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                            @elseif($reservasi->status_reservasi_232112 == 'confirmed')
                                <span class="px-4 py-2 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Confirmed</span>
                            @elseif($reservasi->status_reservasi_232112 == 'cancelled')
                                <span class="px-4 py-2 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Cancelled</span>
                            @else
                                <span class="px-4 py-2 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">Completed</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-gray-500 mb-4">Belum ada reservasi</p>
                <a href="{{ route('user.lapangan.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                    Booking Sekarang
                </a>
            </div>
            @endif
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sliderContainer = document.getElementById('slider-container');
            const slides = sliderContainer.querySelectorAll(':scope > div');
            const dots = document.querySelectorAll('.slider-dot');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            let currentIndex = 0;
            const totalSlides = slides.length;

            // Function to update slider position
            function updateSlider() {
                sliderContainer.style.transform = `translateX(-${currentIndex * 100}%)`;

                // Update active dot
                dots.forEach((dot, index) => {
                    if (index === currentIndex) {
                        dot.classList.add('bg-opacity-100');
                    } else {
                        dot.classList.remove('bg-opacity-100');
                    }
                });
            }

            // Auto slide every 5 seconds
            let autoSlide = setInterval(() => {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateSlider();
            }, 5000);

            // Next button functionality
            nextBtn.addEventListener('click', function() {
                clearInterval(autoSlide);
                currentIndex = (currentIndex + 1) % totalSlides;
                updateSlider();

                // Restart auto slide
                autoSlide = setInterval(() => {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    updateSlider();
                }, 5000);
            });

            // Previous button functionality
            prevBtn.addEventListener('click', function() {
                clearInterval(autoSlide);
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateSlider();

                // Restart auto slide
                autoSlide = setInterval(() => {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    updateSlider();
                }, 5000);
            });

            // Dot navigation functionality
            dots.forEach((dot, index) => {
                dot.addEventListener('click', function() {
                    clearInterval(autoSlide);
                    currentIndex = index;
                    updateSlider();

                    // Restart auto slide
                    autoSlide = setInterval(() => {
                        currentIndex = (currentIndex + 1) % totalSlides;
                        updateSlider();
                    }, 5000);
                });
            });

            // Initialize slider
            updateSlider();
        });
    </script>
@endsection
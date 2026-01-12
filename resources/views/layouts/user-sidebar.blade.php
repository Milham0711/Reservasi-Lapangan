<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SportVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white min-h-screen shadow-lg flex flex-col sticky top-0 h-screen">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-blue-600 text-center">SportVenue</h1>
                <h1 class="ml-3 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full text-center">{{ Auth::user()->nama_232112 }}</h1>
            </div>
            <nav class="p-4">
                <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 {{ Request::routeIs('user.dashboard') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('user.lapangan.index') }}" class="flex items-center space-x-3 px-4 py-3 {{ Request::routeIs('user.lapangan.*') || Request::routeIs('user.reservasi.create') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>Lapangan</span>
                </a>
                <a href="{{ route('user.reservasi.index') }}" class="flex items-center space-x-3 px-4 py-3 {{ Request::routeIs('user.reservasi.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Reservasi Saya</span>
                </a>
            </nav>
            <div class="flex items-center justify-center border-t border-gray-200 mt-auto py-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition items-center">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

            <!-- Page Content -->
            <main class="flex-1 p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
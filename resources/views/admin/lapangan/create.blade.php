<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lapangan - SportVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-blue-600">SportVenue</span>
                    <span class="ml-3 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Admin</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ Auth::user()->nama_232112 }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white min-h-screen shadow-lg">
            <nav class="p-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.lapangan.index') }}" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span class="font-semibold">Kelola Lapangan</span>
                </a>
                <a href="{{ route('admin.reservasi.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>Kelola Reservasi</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="max-w-3xl mx-auto">
                <div class="mb-8">
                    <a href="{{ route('admin.lapangan.index') }}" class="flex items-center text-blue-600 hover:text-blue-800 mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Kelola Lapangan
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800">Tambah Lapangan Baru</h1>
                    <p class="text-gray-600 mt-1">Isi form berikut untuk menambahkan lapangan baru</p>
                </div>

                <!-- Form Tambah Lapangan -->
                <div class="bg-white rounded-xl shadow-md p-8">
                    <form action="{{ route('admin.lapangan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lapangan -->
                            <div class="md:col-span-2">
                                <label for="nama_lapangan" class="block text-sm font-medium text-gray-700 mb-2">Nama Lapangan</label>
                                <input 
                                    type="text" 
                                    id="nama_lapangan" 
                                    name="nama_lapangan" 
                                    value="{{ old('nama_lapangan') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Contoh: Lapangan Futsal ABC"
                                    required
                                >
                                @error('nama_lapangan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Lapangan -->
                            <div>
                                <label for="jenis_lapangan" class="block text-sm font-medium text-gray-700 mb-2">Jenis Lapangan</label>
                                <select 
                                    id="jenis_lapangan" 
                                    name="jenis_lapangan" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    required
                                >
                                    <option value="" disabled selected>Pilih Jenis Lapangan</option>
                                    <option value="futsal" {{ old('jenis_lapangan') == 'futsal' ? 'selected' : '' }}>Futsal</option>
                                    <option value="badminton" {{ old('jenis_lapangan') == 'badminton' ? 'selected' : '' }}>Badminton</option>
                                    <option value="sepak bola" {{ old('jenis_lapangan') == 'sepak bola' ? 'selected' : '' }}>Sepak Bola</option>
                                    <option value="basket" {{ old('jenis_lapangan') == 'basket' ? 'selected' : '' }}>Basket</option>
                                    <option value="voli" {{ old('jenis_lapangan') == 'voli' ? 'selected' : '' }}>Voli</option>
                                    <option value="tenis" {{ old('jenis_lapangan') == 'tenis' ? 'selected' : '' }}>Tenis</option>
                                    <option value="bulu tangkis" {{ old('jenis_lapangan') == 'bulu tangkis' ? 'selected' : '' }}>Bulu Tangkis</option>
                                </select>
                                @error('jenis_lapangan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga per Jam -->
                            <div>
                                <label for="harga_per_jam" class="block text-sm font-medium text-gray-700 mb-2">Harga per Jam (Rp)</label>
                                <input 
                                    type="number" 
                                    id="harga_per_jam" 
                                    name="harga_per_jam" 
                                    value="{{ old('harga_per_jam') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Contoh: 100000"
                                    min="0"
                                    required
                                >
                                @error('harga_per_jam')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kapasitas -->
                            <div>
                                <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-2">Kapasitas (orang)</label>
                                <input 
                                    type="number" 
                                    id="kapasitas" 
                                    name="kapasitas" 
                                    value="{{ old('kapasitas') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Contoh: 10"
                                    min="1"
                                    required
                                >
                                @error('kapasitas')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select 
                                    id="status" 
                                    name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    required
                                >
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gambar -->
                            <div class="md:col-span-2">
                                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">Gambar Lapangan</label>
                                <div class="flex items-center">
                                    <label for="gambar" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                            <p class="text-xs text-gray-500">JPG, PNG, atau JPEG (MAX. 2MB)</p>
                                        </div>
                                        <input id="gambar" type="file" name="gambar" class="hidden" accept="image/*" />
                                    </label>
                                </div>
                                @error('gambar')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="md:col-span-2">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                <textarea 
                                    id="deskripsi" 
                                    name="deskripsi" 
                                    rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Deskripsi tentang lapangan ini..."
                                >{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('admin.lapangan.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition shadow-lg hover:shadow-xl">
                                Tambah Lapangan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
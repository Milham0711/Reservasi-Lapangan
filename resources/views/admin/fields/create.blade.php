<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lapangan - SportVenue Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f8f9fa; }
        .navbar { background: linear-gradient(to right, #dc2626, #ef4444); color: white; padding: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .container { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 1rem; }
        .btn { background: #dc2626; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-secondary { background: #6c757d; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #dee2e6; border-radius: 5px; font-size: 14px; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .alert { padding: 12px; border-radius: 5px; margin-bottom: 1rem; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .required { color: #dc3545; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <h1>SportVenue - Admin Panel</h1>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <a href="{{ route('admin.fields') }}" style="color: white; text-decoration: none;">← Kembali ke Kelola Lapangan</a>
                <div>Welcome, {{ $user['name'] }}</div>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <h2>Tambah Lapangan Baru</h2>

            <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama_lapangan_232112">Nama Lapangan <span class="required">*</span></label>
                    <input type="text" id="nama_lapangan_232112" name="nama_lapangan_232112" value="{{ old('nama_lapangan_232112') }}" required>
                </div>

                <div class="form-group">
                    <label for="jenis_lapangan_232112">Jenis lapangan <span class="required">*</span></label>
                    <select id="jenis_lapangan_232112" name="jenis_lapangan_232112" required>
                        <option value="">Pilih Jenis lapangan</option>
                        <option value="sepak bola" {{ old('jenis_lapangan_232112') == 'sepak bola' ? 'selected' : '' }}>Sepak Bola</option>
                        <option value="basket" {{ old('jenis_lapangan_232112') == 'basket' ? 'selected' : '' }}>Basket</option>
                        <option value="voli" {{ old('jenis_lapangan_232112') == 'voli' ? 'selected' : '' }}>Voli</option>
                        <option value="badminton" {{ old('jenis_lapangan_232112') == 'badminton' ? 'selected' : '' }}>Badminton</option>
                        <option value="tenis" {{ old('jenis_lapangan_232112') == 'tenis' ? 'selected' : '' }}>Tenis</option>
                        <option value="futsal" {{ old('jenis_lapangan_232112') == 'futsal' ? 'selected' : '' }}>Futsal</option>
                        <option value="bulu tangkis" {{ old('jenis_lapangan_232112') == 'bulu tangkis' ? 'selected' : '' }}>Bulu Tangkis</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="harga_per_jam_232112">Harga per Jam (Rp) <span class="required">*</span></label>
                    <input type="number" id="harga_per_jam_232112" name="harga_per_jam_232112" value="{{ old('harga_per_jam_232112') }}" min="0" required>
                </div>

                <div class="form-group">
                    <label for="kapasitas_232112">Kapasitas (orang) <span class="required">*</span></label>
                    <input type="number" id="kapasitas_232112" name="kapasitas_232112" value="{{ old('kapasitas_232112') }}" min="1" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi_232112">Deskripsi</label>
                    <textarea id="deskripsi_232112" name="deskripsi_232112">{{ old('deskripsi_232112') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="gambar_232112">Gambar Lapangan</label>
                    <input type="file" id="gambar_232112" name="gambar_232112" accept="image/*">
                    <small style="color: #666; display: block; margin-top: 5px;">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                </div>

                <div class="form-group">
                    <label for="status_232112">Status <span class="required">*</span></label>
                    <select id="status_232112" name="status_232112" required>
                        <option value="active" {{ old('status_232112', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status_232112') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn">Simpan Lapangan</button>
                    <a href="{{ route('admin.fields') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Format harga input
        document.getElementById('harga_per_jam_232112').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value < 0) {
                e.target.value = 0;
            }
        });

        // Format kapasitas input
        document.getElementById('kapasitas_232112').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value < 1) {
                e.target.value = 1;
            }
        });
    </script>
</body>
</html>

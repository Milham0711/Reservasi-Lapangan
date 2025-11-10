<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lapangan - SportVenue Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f8f9fa; }
        .navbar { background: linear-gradient(to right, #dc2626, #ef4444); color: white; padding: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .container { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { background: #dc2626; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; font-size: 14px; }
        .btn-secondary { background: #6c757d; }
        .btn-success { background: #28a745; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2d3748; }
        .form-control { 
            width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 5px;
            font-size: 1rem; transition: border-color 0.3s ease;
        }
        .form-control:focus { outline: none; border-color: #dc2626; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .alert { padding: 12px; border-radius: 5px; margin-bottom: 1rem; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .image-preview { 
            max-width: 200px; max-height: 200px; margin-top: 10px; 
            border: 2px solid #e2e8f0; border-radius: 5px; display: block;
        }
        .text-danger { color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem; }
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

        <div class="card">
            <h2>Edit Lapangan</h2>

            <form method="POST" action="{{ route('admin.fields.update', $field->lapangan_id_232112) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nama Lapangan</label>
                    <input type="text" name="nama_lapangan_232112" class="form-control" 
                           value="{{ old('nama_lapangan_232112', $field->nama_lapangan_232112) }}" required>
                    @if($errors->has('nama_lapangan_232112'))
                        <div class="text-danger">{{ $errors->first('nama_lapangan_232112') }}</div>
                    @endif
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Jenis Olahraga</label>
                        <select name="jenis_olahraga_232112" class="form-control" required>
                            <option value="">-- Pilih Jenis Olahraga --</option>
                            <option value="futsal" {{ old('jenis_olahraga_232112', $field->jenis_olahraga_232112) == 'futsal' ? 'selected' : '' }}>Futsal</option>
                            <option value="badminton" {{ old('jenis_olahraga_232112', $field->jenis_olahraga_232112) == 'badminton' ? 'selected' : '' }}>Badminton</option>
                            <option value="basket" {{ old('jenis_olahraga_232112', $field->jenis_olahraga_232112) == 'basket' ? 'selected' : '' }}>Basket</option>
                            <option value="tennis" {{ old('jenis_olahraga_232112', $field->jenis_olahraga_232112) == 'tennis' ? 'selected' : '' }}>Tenis</option>
                            <option value="voli" {{ old('jenis_olahraga_232112', $field->jenis_olahraga_232112) == 'voli' ? 'selected' : '' }}>Voli</option>
                        </select>
                        @if($errors->has('jenis_olahraga_232112'))
                            <div class="text-danger">{{ $errors->first('jenis_olahraga_232112') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status_232112" class="form-control" required>
                            <option value="active" {{ old('status_232112', $field->status_232112) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status_232112', $field->status_232112) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @if($errors->has('status_232112'))
                            <div class="text-danger">{{ $errors->first('status_232112') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Harga per Jam (Rp)</label>
                        <input type="number" name="harga_per_jam_232112" class="form-control" 
                               value="{{ old('harga_per_jam_232112', $field->harga_per_jam_232112) }}" min="0" required>
                        @if($errors->has('harga_per_jam_232112'))
                            <div class="text-danger">{{ $errors->first('harga_per_jam_232112') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kapasitas (Orang)</label>
                        <input type="number" name="kapasitas_232112" class="form-control" 
                               value="{{ old('kapasitas_232112', $field->kapasitas_232112) }}" min="1" required>
                        @if($errors->has('kapasitas_232112'))
                            <div class="text-danger">{{ $errors->first('kapasitas_232112') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi_232112" class="form-control" rows="4">{{ old('deskripsi_232112', $field->deskripsi_232112) }}</textarea>
                    @if($errors->has('deskripsi_232112'))
                        <div class="text-danger">{{ $errors->first('deskripsi_232112') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Gambar Lapangan</label>
                    <input type="file" name="gambar_232112" class="form-control" accept="image/*">
                    @if($errors->has('gambar_232112'))
                        <div class="text-danger">{{ $errors->first('gambar_232112') }}</div>
                    @endif
                    
                    @if($field->gambar_232112)
                        <p style="margin-top: 10px; font-size: 0.9rem; color: #666;">Gambar saat ini:</p>
                        <img src="{{ asset($field->gambar_232112) }}" alt="Gambar Lapangan" class="image-preview">
                    @endif
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
                    <a href="{{ route('admin.fields') }}" class="btn btn-secondary">❌ Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
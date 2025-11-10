<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Reservasi - SportVenue</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }

        .container { max-width: 800px; margin: 0 auto; }

        .navbar {
            background: rgba(255, 255, 255, 0.95); padding: 1rem 2rem; border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); margin-bottom: 2rem;
            display: flex; justify-content: space-between; align-items: center;
        }
        .navbar-brand h1 { color: #2d3748; font-size: 1.5rem; font-weight: 700; }

        .card {
            background: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-header { text-align: center; margin-bottom: 2rem; }
        .form-header h1 { font-size: 2rem; color: #2d3748; margin-bottom: 0.5rem; }
        .form-header p { color: #718096; }

        .reservation-summary {
            background: #f8fafc; padding: 1.5rem; border-radius: 15px;
            border-left: 4px solid #4299e1; margin-bottom: 2rem;
        }
        .summary-title { font-size: 1.2rem; font-weight: 600; color: #2d3748; margin-bottom: 1rem; }
        .summary-item {
            display: flex; justify-content: space-between; margin-bottom: 0.5rem;
            padding-bottom: 0.5rem; border-bottom: 1px solid #e2e8f0;
        }
        .summary-label { color: #718096; }
        .summary-value { font-weight: 600; color: #2d3748; }

        .payment-methods { margin: 2rem 0; }
        .payment-title { font-size: 1.2rem; font-weight: 600; color: #2d3748; margin-bottom: 1rem; }
        .payment-options { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .payment-option {
            border: 2px solid #e2e8f0; border-radius: 10px; padding: 1.5rem;
            cursor: pointer; transition: all 0.3s ease; text-align: center;
            background: white;
        }
        .payment-option:hover { border-color: #667eea; transform: translateY(-2px); }
        .payment-option.selected { border-color: #667eea; background: #f0f4ff; }
        .payment-icon { font-size: 2rem; margin-bottom: 0.5rem; }
        .payment-name { font-weight: 600; color: #2d3748; margin-bottom: 0.25rem; }
        .payment-desc { font-size: 0.85rem; color: #718096; }
        .payment-input { display: none; }

        .payment-details {
            background: white; padding: 1.5rem; border-radius: 10px; margin-top: 1rem;
            border-left: 4px solid #4299e1;
        }
        .payment-details.hidden { display: none; }
        .bank-list, .ewallet-list { margin-top: 0.5rem; }
        .bank-item, .ewallet-item {
            display: flex; align-items: center; padding: 0.75rem;
            background: #f7fafc; border-radius: 8px; margin-bottom: 0.5rem;
            cursor: pointer; transition: all 0.3s ease;
        }
        .bank-item:hover, .ewallet-item:hover { background: #edf2f7; }
        .bank-item.selected, .ewallet-item.selected {
            background: #e6fffa; border: 2px solid #38b2ac;
        }
        .bank-logo, .ewallet-logo {
            width: 40px; height: 40px; border-radius: 5px; margin-right: 1rem;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; color: white; font-size: 0.8rem;
        }

        .upload-section {
            background: #f8fafc; padding: 1.5rem; border-radius: 10px;
            border-left: 4px solid #48bb78; margin-top: 1rem;
        }
        .upload-title { font-weight: 600; color: #2d3748; margin-bottom: 1rem; }
        .file-upload {
            border: 2px dashed #cbd5e0; border-radius: 8px; padding: 2rem;
            text-align: center; cursor: pointer; transition: all 0.3s ease;
        }
        .file-upload:hover { border-color: #667eea; background: #f0f4ff; }
        .file-upload input[type="file"] { display: none; }
        .file-upload-label { color: #718096; }

        .btn {
            padding: 12px 30px; border: none; border-radius: 10px; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
            transition: all 0.3s ease; cursor: pointer; font-size: 1rem;
        }
        .btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
        .btn-secondary { background: #718096; color: white; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); }

        .action-buttons { display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; }

        .alert { padding: 1rem; border-radius: 10px; margin-bottom: 1rem; }
        .alert-success { background: rgba(72, 187, 120, 0.2); color: #22543d; border: 1px solid #9ae6b4; }
        .alert-error { background: rgba(245, 101, 101, 0.2); color: #742a2a; border: 1px solid #feb2b2; }

        @media (max-width: 768px) {
            .payment-options { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="navbar-brand"><h1>🏟️ SportVenue</h1></div>
            <div style="color: #4a5568;">
                <div style="font-weight: 600;">{{ $user['name'] }}</div>
                <div>Pembayaran Reservasi</div>
            </div>
        </nav>

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
            <div class="form-header">
                <h1>💳 Pembayaran Reservasi</h1>
                <p>Kode Booking: <strong>{{ $reservation->code }}</strong></p>
            </div>

            <div class="reservation-summary">
                <div class="summary-title">📋 Detail Reservasi</div>
                <div class="summary-item">
                    <div class="summary-label">Lapangan:</div>
                    <div class="summary-value">{{ $reservation->lapangan->nama_lapangan_232112 }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Tanggal:</div>
                    <div class="summary-value">{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Waktu:</div>
                    <div class="summary-value">{{ $reservation->start_time }} - {{ $reservation->end_time }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Durasi:</div>
                    <div class="summary-value">{{ $reservation->duration_hours }} jam</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Harga per Jam:</div>
                    <div class="summary-value">Rp {{ number_format($reservation->lapangan->harga_per_jam_232112, 0, ',', '.') }}</div>
                </div>
                <div class="summary-item" style="border-bottom: none; border-top: 2px solid #4299e1; margin-top: 1rem; padding-top: 1rem;">
                    <div class="summary-label" style="font-weight: 600;">Total Bayar:</div>
                    <div class="summary-value" style="font-size: 1.2rem; color: #667eea;">Rp {{ number_format($reservation->total, 0, ',', '.') }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('reservations.process-payment', $reservation->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="payment-methods">
                    <div class="payment-title">💰 Metode Pembayaran</div>
                    <div class="payment-options">
                        <label class="payment-option" onclick="selectPayment('transfer')">
                            <input type="radio" name="payment_method" value="transfer" class="payment-input" required>
                            <div class="payment-icon">🏦</div>
                            <div class="payment-name">Transfer Bank</div>
                            <div class="payment-desc">Bayar via transfer bank</div>
                        </label>

                        <label class="payment-option" onclick="selectPayment('ewallet')">
                            <input type="radio" name="payment_method" value="ewallet" class="payment-input">
                            <div class="payment-icon">📱</div>
                            <div class="payment-name">E-Wallet</div>
                            <div class="payment-desc">Gopay, OVO, Dana, dll</div>
                        </label>

                        <label class="payment-option" onclick="selectPayment('cash')">
                            <input type="radio" name="payment_method" value="cash" class="payment-input">
                            <div class="payment-icon">💵</div>
                            <div class="payment-name">Cash</div>
                            <div class="payment-desc">Bayar di tempat</div>
                        </label>
                    </div>
                </div>

                <div id="transferDetails" class="payment-details hidden">
                    <h4>🏦 Pilih Bank Tujuan</h4>
                    <div class="bank-list">
                        <label class="bank-item" onclick="selectBank('bca')">
                            <input type="radio" name="bank" value="bca" style="margin-right: 10px;">
                            <div class="bank-logo" style="background: #0066a9;">BCA</div>
                            <div>
                                <div style="font-weight: 600;">BCA - 1234567890</div>
                                <div style="font-size: 0.8rem; color: #666;">a.n. SportVenue Official</div>
                            </div>
                        </label>
                        <label class="bank-item" onclick="selectBank('bni')">
                            <input type="radio" name="bni" style="margin-right: 10px;">
                            <div class="bank-logo" style="background: #006532;">BNI</div>
                            <div>
                                <div style="font-weight: 600;">BNI - 0987654321</div>
                                <div style="font-size: 0.8rem; color: #666;">a.n. SportVenue Official</div>
                            </div>
                        </label>
                        <label class="bank-item" onclick="selectBank('mandiri')">
                            <input type="radio" name="mandiri" style="margin-right: 10px;">
                            <div class="bank-logo" style="background: #005bac;">MDR</div>
                            <div>
                                <div style="font-weight: 600;">Mandiri - 1122334455</div>
                                <div style="font-size: 0.8rem; color: #666;">a.n. SportVenue Official</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div id="ewalletDetails" class="payment-details hidden">
                    <h4>📱 Pilih E-Wallet</h4>
                    <div class="ewallet-list">
                        <label class="ewallet-item" onclick="selectEWallet('gopay')">
                            <input type="radio" name="ewallet" value="gopay" style="margin-right: 10px;">
                            <div class="ewallet-logo" style="background: #00aa13;">GP</div>
                            <div style="font-weight: 600;">Gopay - 08123456789</div>
                        </label>
                        <label class="ewallet-item" onclick="selectEWallet('ovo')">
                            <input type="radio" name="ewallet" value="ovo" style="margin-right: 10px;">
                            <div class="ewallet-logo" style="background: #4c2a86;">OV</div>
                            <div style="font-weight: 600;">OVO - 08123456789</div>
                        </label>
                        <label class="ewallet-item" onclick="selectEWallet('dana')">
                            <input type="radio" name="ewallet" value="dana" style="margin-right: 10px;">
                            <div class="ewallet-logo" style="background: #108ee9;">DN</div>
                            <div style="font-weight: 600;">DANA - 08123456789</div>
                        </label>
                    </div>
                </div>

                <div id="cashDetails" class="payment-details hidden">
                    <h4>💵 Pembayaran Cash</h4>
                    <p>Anda dapat melakukan pembayaran langsung di lokasi SportVenue sebelum menggunakan lapangan.</p>
                    <div style="background: #fff3cd; padding: 1rem; border-radius: 5px; margin-top: 1rem;">
                        <strong>📍 Lokasi Pembayaran:</strong><br>
                        SportVenue Center<br>
                        Jl. Olahraga No. 123, Jakarta<br>
                        Buka: 08:00 - 22:00 WIB
                    </div>
                </div>

                <div id="uploadSection" class="upload-section hidden">
                    <div class="upload-title">📎 Upload Bukti Pembayaran</div>
                    <div class="file-upload" onclick="document.getElementById('bukti_pembayaran').click()">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">📤</div>
                        <div class="file-upload-label">Klik untuk upload bukti pembayaran</div>
                        <div style="font-size: 0.8rem; color: #666; margin-top: 0.5rem;">Format: JPG, PNG, GIF. Max: 2MB</div>
                        <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*">
                    </div>
                    <div id="fileName" style="margin-top: 1rem; font-size: 0.9rem; color: #666;"></div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary">
                        💳 Proses Pembayaran
                    </button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                        ↩️ Kembali ke Reservasi
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function selectPayment(method) {
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected');
            });

            document.getElementById('transferDetails').classList.add('hidden');
            document.getElementById('ewalletDetails').classList.add('hidden');
            document.getElementById('cashDetails').classList.add('hidden');
            document.getElementById('uploadSection').classList.add('hidden');

            event.currentTarget.classList.add('selected');

            if (method === 'transfer') {
                document.getElementById('transferDetails').classList.remove('hidden');
                document.getElementById('uploadSection').classList.remove('hidden');
            } else if (method === 'ewallet') {
                document.getElementById('ewalletDetails').classList.remove('hidden');
                document.getElementById('uploadSection').classList.remove('hidden');
            } else if (method === 'cash') {
                document.getElementById('cashDetails').classList.remove('hidden');
                // No upload needed for cash
            }
        }

        function selectBank(bank) {
            document.querySelectorAll('.bank-item').forEach(item => {
                item.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
        }

        function selectEWallet(ewallet) {
            document.querySelectorAll('.ewallet-item').forEach(item => {
                item.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
        }

        // File upload preview
        document.getElementById('bukti_pembayaran').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileNameDiv = document.getElementById('fileName');

            if (file) {
                fileNameDiv.textContent = `File dipilih: ${file.name}`;
                fileNameDiv.style.color = '#22543d';
            } else {
                fileNameDiv.textContent = '';
            }
        });
    </script>
</body>
</html>

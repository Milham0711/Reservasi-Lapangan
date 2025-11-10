<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Reservasi - SportVenue</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
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
        
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #2d3748; }
        .form-control { 
            width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 10px;
            font-size: 1rem; transition: border-color 0.3s ease;
        }
        .form-control:focus { outline: none; border-color: #667eea; }
        
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
        .alert-info { background: rgba(144, 205, 244, 0.2); color: #2c5282; border: 1px solid #bee3f8; }

        .form-layout { 
            display: grid; 
            grid-template-columns: 1fr 350px; 
            gap: 2rem; 
            align-items: start; 
        }
        
        .form-section { 
            background: #f8fafc; 
            padding: 1.5rem; 
            border-radius: 15px; 
            border-left: 4px solid #4299e1;
        }
        
        .summary-section { 
            background: linear-gradient(135deg, #667eea, #764ba2); 
            color: white; 
            padding: 1.5rem; 
            border-radius: 15px; 
            position: sticky;
            top: 2rem;
        }

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

        .summary-title { font-size: 1.3rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center; }
        .summary-item { 
            display: flex; justify-content: between; 
            margin-bottom: 0.75rem; padding-bottom: 0.75rem; 
            border-bottom: 1px solid rgba(255,255,255,0.2); 
        }
        .summary-label { flex: 1; color: rgba(255,255,255,0.8); }
        .summary-value { font-weight: 600; }
        .summary-total { 
            font-size: 1.4rem; font-weight: 700; 
            margin-top: 1rem; padding-top: 1rem;
            border-top: 2px solid rgba(255,255,255,0.3);
        }
        
        .payment-status { 
            display: inline-block; padding: 0.5rem 1rem; border-radius: 20px; 
            font-size: 0.9rem; font-weight: 600; margin-top: 1rem; text-align: center;
            width: 100%;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-failed { background: #f8d7da; color: #721c24; }
        
        .payment-date { 
            text-align: center; margin-top: 0.5rem; 
            font-size: 0.9rem; color: rgba(255,255,255,0.8);
        }

        @media (max-width: 768px) {
            .form-layout { grid-template-columns: 1fr; }
            .payment-options { grid-template-columns: 1fr; }
            .summary-section { position: static; }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="navbar-brand"><h1>🏟️ SportVenue</h1></div>
            <div style="color: #4a5568;">
                <div style="font-weight: 600;">{{ $user['name'] }}</div>
                <div>Buat Reservasi & Pembayaran</div>
            </div>
        </nav>

        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="card">
            <div class="form-header">
                <h1>Form Reservasi Lapangan</h1>
                <p>Isi form berikut untuk melakukan reservasi dan pembayaran</p>
            </div>

            <div class="form-layout">
                <div class="form-section">
                    <form method="POST" action="{{ route('reservations.store') }}" id="reservationForm">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label">Pilih Jenis Lapangan</label>
                            <select name="sport_type" id="sportType" class="form-control" required>
                                <option value="">-- Pilih Jenis Lapangan --</option>
                                <option value="futsal">⚽ Futsal</option>
                                <option value="badminton">🏸 Badminton</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Pilih Lapangan</label>
                            <select name="field_id" id="fieldSelect" class="form-control" required>
                                <option value="">-- Pilih Lapangan --</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tanggal Reservasi</label>
                            <input type="date" name="date" id="reservationDate" class="form-control" min="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Waktu Mulai</label>
                            <input type="time" name="start_time" id="startTime" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Durasi (jam)</label>
                            <select name="duration" id="duration" class="form-control" required>
                                <option value="1">1 Jam</option>
                                <option value="2">2 Jam</option>
                                <option value="3">3 Jam</option>
                                <option value="4">4 Jam</option>
                            </select>
                        </div>
                        
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
                                    <input type="radio" name="bank" value="bni" style="margin-right: 10px;">
                                    <div class="bank-logo" style="background: #006532;">BNI</div>
                                    <div>
                                        <div style="font-weight: 600;">BNI - 0987654321</div>
                                        <div style="font-size: 0.8rem; color: #666;">a.n. SportVenue Official</div>
                                    </div>
                                </label>
                                <label class="bank-item" onclick="selectBank('mandiri')">
                                    <input type="radio" name="bank" value="mandiri" style="margin-right: 10px;">
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
                    </form>
                </div>
                <div class="summary-section">
                    <div class="summary-title">📋 Ringkasan Pesanan</div>
                    
                    <div class="summary-item">
                        <div class="summary-label">Lapangan:</div>
                        <div class="summary-value" id="summaryField">-</div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-label">Tanggal:</div>
                        <div class="summary-value" id="summaryDate">-</div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-label">Waktu:</div>
                        <div class="summary-value" id="summaryTime">-</div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-label">Durasi:</div>
                        <div class="summary-value" id="summaryDuration">-</div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-label">Harga/jam:</div>
                        <div class="summary-value" id="summaryPrice">-</div>
                    </div>
                    
                    <div class="summary-total">
                        <div class="summary-item">
                            <div class="summary-label">Total Bayar:</div>
                            <div class="summary-value" id="summaryTotal">Rp 0</div>
                        </div>
                    </div>
                    <div class="payment-status status-pending" id="paymentStatus">
                        ⏳ Menunggu Pembayaran
                    </div>
                    
                    <div class="payment-date" id="paymentDate">
                        -
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button type="submit" form="reservationForm" class="btn btn-primary">
                    💳 Lanjutkan Pembayaran
                </button>
                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                    ↩️ Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        const fields = {
            futsal: [
                { 
                    id: 'futsal_vinyl', 
                    name: 'Lapangan Vinyl Futsal',  
                    price: 50000  
                },
                { 
                    id: 'futsal_sintetis', 
                    name: 'Lapangan Sintetis Futsal',  
                    price: 40000 
                }
            ],
            badminton: [
                { id: 'badminton_1', name: 'Badminton 1', price: 80000 },
                { id: 'badminton_2', name: 'Badminton 2', price: 80000 },
                { id: 'badminton_3', name: 'Badminton 3', price: 80000 }
            ]
        };

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded - initializing fields');
            
            updateFields();
            
            document.getElementById('sportType').addEventListener('change', updateFields);
            document.getElementById('fieldSelect').addEventListener('change', updateSummary);
            document.getElementById('reservationDate').addEventListener('change', updateSummary);
            document.getElementById('startTime').addEventListener('change', updateSummary);
            document.getElementById('duration').addEventListener('change', updateSummary);
            
            document.getElementById('reservationDate').min = new Date().toISOString().split('T')[0];
            
            const nextHour = new Date();
            nextHour.setHours(nextHour.getHours() + 1);
            nextHour.setMinutes(0);
            document.getElementById('startTime').value = nextHour.toTimeString().slice(0, 5);
            
            updateSummary();
        });

        function updateFields() {
            console.log('updateFields called');
            const sportType = document.getElementById('sportType').value;
            const fieldSelect = document.getElementById('fieldSelect');
            
            console.log('Sport type:', sportType);
            
            if (!fieldSelect) {
                console.error('fieldSelect element not found!');
                return;
            }
            
            fieldSelect.innerHTML = '<option value="">-- Pilih Lapangan --</option>';
            
            if (sportType && fields[sportType]) {
                console.log('Fields found:', fields[sportType]);
                fields[sportType].forEach(field => {
                    const option = document.createElement('option');
                    option.value = field.id;
                    option.textContent = `${field.name} - Rp ${field.price.toLocaleString()}/jam`;
                    option.setAttribute('data-price', field.price);
                    option.setAttribute('data-name', field.name);
                    fieldSelect.appendChild(option);
                });
            } else {
                console.log('No fields for sport type:', sportType);
            }
            
            updateSummary();
        }

        function updateSummary() {
            const fieldSelect = document.getElementById('fieldSelect');
            const duration = document.getElementById('duration').value;
            const date = document.getElementById('reservationDate').value;
            const time = document.getElementById('startTime').value;
            
            const selectedField = fieldSelect.options[fieldSelect.selectedIndex];
            
            document.getElementById('summaryField').textContent = selectedField.value ? 
                selectedField.getAttribute('data-name') : '-';
            document.getElementById('summaryDate').textContent = date || '-';
            document.getElementById('summaryTime').textContent = time || '-';
            document.getElementById('summaryDuration').textContent = duration ? `${duration} jam` : '-';
            
            if (selectedField.value && duration) {
                const pricePerHour = parseInt(selectedField.getAttribute('data-price'));
                const total = pricePerHour * parseInt(duration);
                
                document.getElementById('summaryPrice').textContent = `Rp ${pricePerHour.toLocaleString()}`;
                document.getElementById('summaryTotal').textContent = `Rp ${total.toLocaleString()}`;
                
                const now = new Date();
                document.getElementById('paymentDate').textContent = 
                    `Dibuat: ${now.toLocaleDateString('id-ID')} ${now.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}`;
            } else {
                document.getElementById('summaryPrice').textContent = '-';
                document.getElementById('summaryTotal').textContent = 'Rp 0';
                document.getElementById('paymentDate').textContent = '-';
            }
        }

        function selectPayment(method) {
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            document.getElementById('transferDetails').classList.add('hidden');
            document.getElementById('ewalletDetails').classList.add('hidden');
            document.getElementById('cashDetails').classList.add('hidden');
            
            event.currentTarget.classList.add('selected');
            
            if (method === 'transfer') {
                document.getElementById('transferDetails').classList.remove('hidden');
            } else if (method === 'ewallet') {
                document.getElementById('ewalletDetails').classList.remove('hidden');
            } else if (method === 'cash') {
                document.getElementById('cashDetails').classList.remove('hidden');
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
    </script>
</body>
</html>
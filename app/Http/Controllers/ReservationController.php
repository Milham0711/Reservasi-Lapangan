<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReservationController extends Controller
{
    private $reservations = [
        [
            'id' => '1',
            'user_email' => 'user@sportvenue.com',
            'user_name' => 'Rahmat',
            'field_id' => 'futsal_vinyl',
            'field_name' => 'Lapangan Vinyl Futsal',
            'sport_type' => 'futsal',
            'date' => '2024-10-25',
            'start_time' => '19:00',
            'duration' => 2,
            'total_price' => 100000,  
            'status' => 'confirmed',
            'created_at' => '2024-10-20 10:00:00'
        ],
        [
            'id' => '2', 
            'user_email' => 'user2@example.com',
            'user_name' => 'Adhi',
            'field_id' => 'badminton_2',
            'field_name' => 'Badminton 2',
            'sport_type' => 'badminton',
            'date' => '2024-10-26',
            'start_time' => '16:00',
            'duration' => 1,
            'total_price' => 80000,  
            'status' => 'pending',
            'created_at' => '2024-10-21 14:30:00'
        ],
        [
            'id' => '3',
            'user_email' => 'user3@example.com',
            'user_name' => 'Sharga',
            'field_id' => 'futsal_sintetis',
            'field_name' => 'Lapangan Sintetis Futsal',
            'sport_type' => 'futsal',
            'date' => '2024-10-27',
            'start_time' => '20:00',
            'duration' => 3,
            'total_price' => 120000,  
            'status' => 'confirmed',
            'created_at' => '2024-10-22 09:15:00'
        ]
    ];

    public function index()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $user = Session::get('user');
        
        // Get reservations from database
        $userReservations = \App\Models\Reservasi::with(['lapangan', 'pembayaran'])
            ->where('user_id_232112', $user['id'])
            ->orderBy('created_at_232112', 'desc')
            ->get();

        return view('reservations.index', [
            'user' => $user,
            'reservations' => $userReservations
        ]);
    }

    public function create(\Illuminate\Http\Request $request)
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $data = ['user' => Session::get('user')];

        // If lapangan_id is provided (from location detail), attempt to load and prefill
        if ($request->has('lapangan_id')) {
            try {
                $lapangan = \App\Models\Lapangan::find($request->get('lapangan_id'));
                if ($lapangan) {
                    $data['prefill'] = [
                        'id' => $lapangan->id,
                        'name' => $lapangan->name,
                        'type' => $lapangan->type,
                        'price' => $lapangan->price,
                        'image' => $lapangan->image ?? null,
                    ];
                }
            } catch (\Exception $e) {
                // ignore and continue without prefill
            }
        }

        return view('reservations.create', $data);
    }

    public function store(Request $request)
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $request->validate([
            'sport_type' => 'required|string',
            'field_id' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'duration' => 'required|integer|min:1|max:4',
            'payment_method' => 'required|in:transfer,ewallet,cash'
        ]);

        $user = Session::get('user');

        // Get field details from database
        // First try to find by lapangan_id_232112, if not found try by friendly id
        $field = \App\Models\Lapangan::where('lapangan_id_232112', $request->field_id)
            ->orWhere('id', $request->field_id)
            ->first();
            
        if (!$field) {
            return back()->with('error', 'Lapangan tidak ditemukan. ID: ' . $request->field_id);
        }

        // Calculate total price
        $totalPrice = $field->harga_per_jam_232112 * $request->duration;

        // Calculate end time
        $startTime = $request->start_time;
        $endTime = date('H:i', strtotime($startTime) + ($request->duration * 3600));

        // Generate booking code
        $bookingCode = 'RSV' . date('Ymd') . rand(1000, 9999);

        try {
            // Create reservation
            $reservation = \App\Models\Reservasi::create([
                'user_id_232112' => $user['id'],
                'lapangan_id_232112' => $field->lapangan_id_232112,
                'tanggal_reservasi_232112' => $request->date,
                'waktu_mulai_232112' => $startTime,
                'waktu_selesai_232112' => $endTime,
                'total_harga_232112' => $totalPrice,
                'status_reservasi_232112' => 'pending',
                'catatan_232112' => 'Kode Booking: ' . $bookingCode
            ]);

            // Create payment record
            $paymentMethod = $request->payment_method;
            $paymentStatus = ($paymentMethod === 'cash') ? 'pending' : 'pending';

            $payment = \App\Models\Pembayaran::create([
                'reservasi_id_232112' => $reservation->reservasi_id_232112,
                'jumlah_pembayaran_232112' => $totalPrice,
                'metode_pembayaran_232112' => $paymentMethod,
                'status_pembayaran_232112' => $paymentStatus,
                'tanggal_pembayaran_232112' => now()
            ]);

            // Create notification
            \App\Models\Notifikasi::create([
                'user_id_232112' => $user['id'],
                'judul_notifikasi_232112' => 'Reservasi Berhasil Dibuat',
                'isi_notifikasi_232112' => "Reservasi {$bookingCode} telah dibuat. Silakan selesaikan pembayaran.",
                'tipe_notifikasi_232112' => 'info',
                'sudah_dibaca_232112' => false
            ]);

            return redirect()->route('reservations.payment', $reservation->reservasi_id_232112)
                            ->with('success', 'Reservasi berhasil dibuat! Silakan selesaikan pembayaran.');
                            
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Reservation creation failed: ' . $e->getMessage());
            \Log::error('Request data: ' . json_encode($request->all()));
            \Log::error('User data: ' . json_encode($user));
            \Log::error('Field data: ' . json_encode($field));
            
            return back()->with('error', 'Gagal membuat reservasi: ' . $e->getMessage())
                        ->withInput();
        }
    }

    public function allReservations()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        // Get all reservations from database
        $allReservations = \App\Models\Reservasi::with(['lapangan', 'pembayaran'])
            ->orderBy('created_at_232112', 'desc')
            ->get();

        return view('reservations.admin-index', [
            'user' => Session::get('user'),
            'reservations' => $allReservations
        ]);
    }

    public function edit($id)
    {
        return back()->with('info', 'Fitur edit reservasi sedang dalam pengembangan.');
    }

    public function update(Request $request, $id)
    {
        return back()->with('info', 'Fitur update reservasi sedang dalam pengembangan.');
    }

    public function destroy($id)
    {
        return back()->with('info', 'Fitur hapus reservasi sedang dalam pengembangan.');
    }

    public function payment($reservationId)
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $user = Session::get('user');

        // Get reservation with payment details
        $reservation = \App\Models\Reservasi::with(['lapangan', 'pembayaran'])
            ->where('reservasi_id_232112', $reservationId)
            ->where('user_id_232112', $user['id'])
            ->first();

        if (!$reservation) {
            return redirect()->route('reservations.index')->with('error', 'Reservasi tidak ditemukan.');
        }

        return view('reservations.payment', [
            'user' => $user,
            'reservation' => $reservation,
            'payment' => $reservation->pembayaran->first()
        ]);
    }

    public function processPayment(Request $request, $reservationId)
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $user = Session::get('user');

        $request->validate([
            'payment_method' => 'required|in:transfer,ewallet,cash',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Get reservation and payment
        $reservation = \App\Models\Reservasi::with('pembayaran')
            ->where('reservasi_id_232112', $reservationId)
            ->where('user_id_232112', $user['id'])
            ->first();

        if (!$reservation) {
            return redirect()->route('reservations.index')->with('error', 'Reservasi tidak ditemukan.');
        }

        $payment = $reservation->pembayaran->first();

        // Handle file upload for payment proof
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $imageName = time() . '_payment_' . $reservationId . '.' . $request->bukti_pembayaran->extension();
            $request->bukti_pembayaran->move(public_path('images/payments'), $imageName);
            $buktiPath = 'images/payments/' . $imageName;
        }

        // Update payment
        $payment->update([
            'metode_pembayaran_232112' => $request->payment_method,
            'bukti_pembayaran_232112' => $buktiPath,
            'status_pembayaran_232112' => ($request->payment_method === 'cash') ? 'pending' : 'pending',
            'tanggal_pembayaran_232112' => now()
        ]);

        // Update reservation status based on payment method
        if ($request->payment_method === 'cash') {
            $reservation->update(['status_reservasi_232112' => 'confirmed']);
            $message = 'Reservasi berhasil dikonfirmasi! Silakan datang ke lokasi untuk pembayaran cash.';
        } else {
            $reservation->update(['status_reservasi_232112' => 'pending']);
            $message = 'Bukti pembayaran telah diupload. Menunggu verifikasi dari admin.';
        }

        // Create notification
        \App\Models\Notifikasi::create([
            'user_id_232112' => $user['id'],
            'judul_notifikasi_232112' => 'Pembayaran Diproses',
            'isi_notifikasi_232112' => $message,
            'tipe_notifikasi_232112' => 'info',
            'sudah_dibaca_232112' => false
        ]);

        return redirect()->route('reservations.index')->with('success', $message);
    }

    public function getFieldsBySportType($sportType)
    {
        try {
            $fields = \App\Models\Lapangan::where('jenis_lapangan_232112', $sportType)
                ->where('status_232112', 'available')
                ->get(['lapangan_id_232112 as id', 'nama_lapangan_232112 as name', 'harga_per_jam_232112 as price']);
            
            return response()->json($fields);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

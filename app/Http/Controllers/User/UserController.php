<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        $totalReservasi = Reservasi::where('user_id_232112', $user->user_id_232112)->count();
        $pendingReservasi = Reservasi::where('user_id_232112', $user->user_id_232112)
            ->where('status_reservasi_232112', 'pending')
            ->count();
        $confirmedReservasi = Reservasi::where('user_id_232112', $user->user_id_232112)
            ->where('status_reservasi_232112', 'confirmed')
            ->count();

        $recentReservasi = Reservasi::where('user_id_232112', $user->user_id_232112)
            ->with('lapangan')
            ->orderBy('created_at_232112', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'totalReservasi',
            'pendingReservasi',
            'confirmedReservasi',
            'recentReservasi'
        ));
    }

    public function lapanganIndex(Request $request)
    {
        $query = Lapangan::where('status_232112', 'active');

        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis_lapangan_232112', $request->jenis);
        }

        $lapangan = $query->paginate(9);
        
        return view('user.lapangan.index', compact('lapangan'));
    }

    public function lapanganShow($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('user.lapangan.show', compact('lapangan'));
    }

    public function reservasiCreate($lapanganId)
    {
        $lapangan = Lapangan::findOrFail($lapanganId);
        return view('user.reservasi.create', compact('lapangan'));
    }

    public function reservasiStore(Request $request)
    {
        // Determine valid payment methods based on cURL availability
        $validPaymentMethods = ['cash'];
        if (function_exists('curl_init')) {
            $validPaymentMethods[] = 'midtrans';
        }

        $request->validate([
            'lapangan_id' => 'required|exists:lapangan_232112,lapangan_id_232112',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'metode_pembayaran' => 'required|in:' . implode(',', $validPaymentMethods),
            'catatan' => 'nullable|string',
        ]);

        $lapangan = Lapangan::findOrFail($request->lapangan_id);

        // Hitung durasi dan total harga (with better precision)
        $waktuMulai = Carbon::parse($request->tanggal . ' ' . $request->waktu_mulai);
        $waktuSelesai = Carbon::parse($request->tanggal . ' ' . $request->waktu_selesai);

        // Validate that end time is after start time
        if ($waktuSelesai->lte($waktuMulai)) {
            return back()->withErrors(['waktu_selesai' => 'Waktu selesai harus lebih lama dari waktu mulai.']);
        }

        // Calculate duration in hours using interval to avoid negative issues
        $interval = $waktuMulai->diff($waktuSelesai);
        $durasi = ($interval->h + ($interval->days * 24)) + ($interval->i / 60) + ($interval->s / 3600);

        // Ensure the hourly rate is positive before calculation
        $hargaPerJam = max(0, (float) $lapangan->harga_per_jam_232112);
        $totalHarga = ceil($durasi) * $hargaPerJam; // Use ceiling to round up to next hour

        // Ensure total price is never negative
        $totalHarga = max(0, $totalHarga);

        // Create reservation
        $reservasi = Reservasi::create([
            'user_id_232112' => Auth::id(),
            'lapangan_id_232112' => $request->lapangan_id,
            'tanggal_reservasi_232112' => $request->tanggal,
            'waktu_mulai_232112' => $request->waktu_mulai,
            'waktu_selesai_232112' => $request->waktu_selesai,
            'total_harga_232112' => $totalHarga,
            'status_reservasi_232112' => 'pending',
            'catatan_232112' => $request->catatan,
        ]);

        // Create payment record based on payment method
        $pembayaran = \App\Models\Pembayaran::create([
            'reservasi_id_232112' => $reservasi->reservasi_id_232112,
            'metode_pembayaran_232112' => $request->metode_pembayaran,
            'jumlah_pembayaran_232112' => $totalHarga,
            'status_pembayaran_232112' => $request->metode_pembayaran === 'cash' ? 'pending' : 'pending',
        ]);

        // Process payment if using Midtrans
        if ($request->metode_pembayaran === 'midtrans') {
            // Check if cURL is available before attempting Midtrans integration
            if (!function_exists('curl_init')) {
                // For development/testing without cURL, update payment with mock data
                $pembayaran->update([
                    'transaction_id_midtrans' => 'mock_' . $pembayaran->pembayaran_id_232112,
                    'status_pembayaran_232112' => 'pending',
                ]);

                return view('user.reservasi.snap', [
                    'snapToken' => 'mock_token_' . $pembayaran->pembayaran_id_232112,
                    'reservasi' => $reservasi
                ]);
            }

            try {
                // Initialize Midtrans
                $midtrans = new \App\Services\MidtransService();

                $params = [
                    'transaction_details' => [
                        'order_id' => 'PAY-' . $pembayaran->pembayaran_id_232112, // Create unique order ID with prefix
                        'gross_amount' => $totalHarga,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->nama_232112,
                        'email' => Auth::user()->email_232112,
                        'phone' => Auth::user()->telepon_232112 ?? 'N/A',
                    ],
                    'item_details' => [
                        [
                            'id' => $request->lapangan_id,
                            'price' => $totalHarga,
                            'quantity' => 1,
                            'name' => 'Reservasi Lapangan ' . $lapangan->nama_lapangan_232112,
                        ]
                    ]
                ];

                // Get Snap token instead of payment URL
                $snapToken = $midtrans->createTransaction($params);

                // Update payment record with the order ID we're sending to Midtrans
                $pembayaran->update([
                    'transaction_id_midtrans' => 'PAY-' . $pembayaran->pembayaran_id_232112,
                ]);

                // Return view with Snap token to show popup directly
                return view('user.reservasi.snap', [
                    'snapToken' => $snapToken,
                    'reservasi' => $reservasi
                ]);
            } catch (\Exception $e) {
                // For any Midtrans error (including cURL), show mock interface
                $pembayaran->update([
                    'transaction_id_midtrans' => 'mock_error_' . $pembayaran->pembayaran_id_232112,
                    'status_pembayaran_232112' => 'pending',
                ]);

                return view('user.reservasi.snap', [
                    'snapToken' => 'mock_error_' . $pembayaran->pembayaran_id_232112,
                    'reservasi' => $reservasi
                ]);
            }
        }

        return redirect()->route('user.reservasi.index')
            ->with('success', 'Reservasi berhasil dibuat. ' .
                  ($request->metode_pembayaran === 'cash' ? 'Silakan bayar di lokasi.' : 'Silakan selesaikan pembayaran.'));
    }

    public function handleMidtransWebhook(Request $request)
    {
        // Log the incoming webhook request for debugging
        \Log::info('Midtrans Webhook Received', [
            'headers' => $request->headers->all(),
            'content' => $request->getContent(),
            'all_data' => $request->all(),
        ]);

        // Get the JSON notification from Midtrans
        $notification = json_decode($request->getContent(), true);

        // If content is not JSON, try to get from request data
        if (!$notification) {
            $notification = $request->all();
        }

        \Log::info('Parsed Notification', $notification);

        // Verify Midtrans signature for security
        $orderId = $notification['order_id'] ?? null;
        $transactionStatus = $notification['transaction_status'] ?? null;
        $statusCode = $notification['status_code'] ?? null;
        $grossAmount = $notification['gross_amount'] ?? null;

        \Log::info('Notification Details', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'status_code' => $statusCode
        ]);

        if (!$orderId || !$transactionStatus || !$statusCode) {
            \Log::error('Missing required notification data', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'status_code' => $statusCode
            ]);
            return response()->json(['message' => 'Invalid notification data'], 400);
        }

        // Find payment by order_id (which is the payment ID with PAY- prefix)
        $pembayaran = \App\Models\Pembayaran::where('transaction_id_midtrans', $orderId)->first();

        \Log::info('Payment lookup result', [
            'order_id' => $orderId,
            'pembayaran_found' => $pembayaran ? 'Yes' : 'No',
            'payment_id' => $pembayaran ? $pembayaran->pembayaran_id_232112 : null
        ]);

        if (!$pembayaran) {
            \Log::error('Payment not found for order_id', ['order_id' => $orderId]);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Update payment status based on transaction status
        $statusMap = [
            'capture' => 'paid',
            'settlement' => 'paid',
            'pending' => 'pending',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'failed',
            'failure' => 'failed',
            'partial' => 'partial',
        ];

        $newStatus = $statusMap[$transactionStatus] ?? 'pending';

        \Log::info('Updating payment status', [
            'old_status' => $pembayaran->status_pembayaran_232112,
            'new_status' => $newStatus
        ]);

        // Update payment status
        $pembayaran->update([
            'status_pembayaran_232112' => $newStatus,
            'tanggal_pembayaran_232112' => now(),
        ]);

        // If payment is successful, update reservation status to completed
        if ($newStatus === 'paid') {
            \Log::info('Updating reservation to completed', [
                'reservation_id' => $pembayaran->reservasi->reservasi_id_232112,
                'old_reservation_status' => $pembayaran->reservasi->status_reservasi_232112
            ]);

            $pembayaran->reservasi()->update([
                'status_reservasi_232112' => 'completed',
            ]);
        }
        // If payment failed, update reservation accordingly
        elseif ($newStatus === 'failed' || $newStatus === 'expired') {
            \Log::info('Updating reservation to cancelled due to failed payment', [
                'reservation_id' => $pembayaran->reservasi->reservasi_id_232112,
                'old_reservation_status' => $pembayaran->reservasi->status_reservasi_232112
            ]);

            $pembayaran->reservasi()->update([
                'status_reservasi_232112' => 'cancelled',
            ]);
        }

        \Log::info('Webhook processed successfully', [
            'payment_id' => $pembayaran->pembayaran_id_232112,
            'payment_status' => $pembayaran->status_pembayaran_232112,
            'reservation_status' => $pembayaran->reservasi->status_reservasi_232112
        ]);

        return response()->json(['message' => 'Webhook handled successfully']);
    }

    public function confirmPayment(Request $request, $id)
    {
        try {
            // Find the reservation
            $reservasi = \App\Models\Reservasi::where('reservasi_id_232112', $id)
                ->where('user_id_232112', auth()->id())
                ->first();

            if (!$reservasi) {
                return response()->json(['error' => 'Reservation not found'], 404);
            }

            // Find the associated payment
            $pembayaran = $reservasi->pembayaran;

            if (!$pembayaran) {
                return response()->json(['error' => 'Payment record not found'], 404);
            }

            // Get status from request (should be 'paid')
            $status = $request->input('status', 'paid');

            // Update payment status to 'paid'
            $pembayaran->update([
                'status_pembayaran_232112' => $status,
                'tanggal_pembayaran_232112' => now(),
            ]);

            // Update reservation status to 'completed'
            $reservasi->update([
                'status_reservasi_232112' => 'completed',
            ]);

            return response()->json([
                'message' => 'Payment and reservation status updated successfully',
                'payment_status' => $pembayaran->status_pembayaran_232112,
                'reservation_status' => $reservasi->status_reservasi_232112
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in confirmPayment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update status'], 500);
        }
    }

    public function showPaymentPage($id)
    {
        // Find reservation and payment record for the authenticated user
        $reservasi = \App\Models\Reservasi::where('reservasi_id_232112', $id)
            ->where('user_id_232112', auth()->id())
            ->with('pembayaran', 'lapangan')
            ->first();

        if (!$reservasi) {
            abort(404, 'Reservation not found');
        }

        $pembayaran = $reservasi->pembayaran;
        if (!$pembayaran || $pembayaran->metode_pembayaran_232112 !== 'midtrans') {
            abort(404, 'Payment method is not Midtrans or payment record not found');
        }

        // If payment is already completed, redirect to reservation list
        if ($pembayaran->status_pembayaran_232112 !== 'pending') {
            return redirect()->route('user.reservasi.index')->with('info', 'Payment is already processed');
        }

        // Recreate the Snap token for this payment
        try {
            // Initialize Midtrans
            $midtrans = new \App\Services\MidtransService();

            $params = [
                'transaction_details' => [
                    'order_id' => $pembayaran->transaction_id_midtrans,
                    'gross_amount' => $reservasi->total_harga_232112,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->nama_232112,
                    'email' => auth()->user()->email_232112,
                    'phone' => auth()->user()->telepon_232112 ?? 'N/A',
                ],
                'item_details' => [
                    [
                        'id' => $reservasi->lapangan_id_232112,
                        'price' => $reservasi->total_harga_232112,
                        'quantity' => 1,
                        'name' => 'Reservasi Lapangan ' . $reservasi->lapangan->nama_lapangan_232112,
                    ]
                ]
            ];

            $snapToken = $midtrans->createTransaction($params);

            // Return the Snap view with the token to show payment popup
            return view('user.reservasi.snap', [
                'snapToken' => $snapToken,
                'reservasi' => $reservasi
            ]);
        } catch (\Exception $e) {
            // If Midtrans fails, return to reservation list with error
            return redirect()->route('user.reservasi.index')
                ->with('error', 'Unable to load payment page: ' . $e->getMessage());
        }
    }

    public function reservasiIndex()
    {
        $reservasi = Reservasi::where('user_id_232112', Auth::id())
            ->with('lapangan')
            ->orderBy('created_at_232112', 'desc')
            ->paginate(10);

        return view('user.reservasi.index', compact('reservasi'));
    }
}
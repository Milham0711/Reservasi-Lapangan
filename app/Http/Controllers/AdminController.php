<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Reservasi;
use App\Models\Lapangan;
use App\Models\UserLegacy;
use App\Models\Pembayaran;
use App\Models\Notifikasi;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        $user = Session::get('user');

        // Get real statistics from database
        $totalReservations = Reservasi::count();
        $activeFields = Lapangan::where('status_232112', 'active')->count();
        $activeUsers = UserLegacy::where('role_232112', 'user')->count();

        // Calculate monthly revenue
        $monthlyRevenue = Pembayaran::where('status_pembayaran_232112', 'paid')
            ->whereMonth('tanggal_pembayaran_232112', Carbon::now()->month)
            ->whereYear('tanggal_pembayaran_232112', Carbon::now()->year)
            ->sum('jumlah_pembayaran_232112');

        // Get today's reservations
        $todayReservations = Reservasi::where('tanggal_reservasi_232112', Carbon::today()->toDateString())->get();

        // Get recent reservations (last 10)
        $recentReservations = Reservasi::with(['lapangan'])
            ->orderBy('created_at_232112', 'desc')
            ->limit(10)
            ->get();

        // Get pending payments
        $pendingPayments = Pembayaran::where('status_pembayaran_232112', 'pending')->count();

        return view('admin.dashboard', compact(
            'user',
            'totalReservations',
            'activeFields',
            'activeUsers',
            'monthlyRevenue',
            'todayReservations',
            'recentReservations',
            'pendingPayments'
        ));
    }

    public function reservations()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        $reservations = Reservasi::with(['lapangan'])
            ->orderBy('created_at_232112', 'desc')
            ->paginate(20);

        return view('admin.reservations.index', [
            'user' => Session::get('user'),
            'reservations' => $reservations
        ]);
    }

    public function fields()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        $fields = Lapangan::orderBy('created_at_232112', 'desc')->get();

        return view('admin.fields.index', [
            'user' => Session::get('user'),
            'fields' => $fields
        ]);
    }

    public function createField()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        return view('admin.fields.create', [
            'user' => Session::get('user')
        ]);
    }

    public function storeField(Request $request)
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        $request->validate([
            'nama_lapangan_232112' => 'required|string|max:255',
            'jenis_lapangan_232112' => 'required|string|max:100',
            'harga_per_jam_232112' => 'required|numeric|min:0',
            'kapasitas_232112' => 'required|integer|min:1',
            'deskripsi_232112' => 'nullable|string',
            'gambar_232112' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_232112' => 'required|in:active,inactive'
        ]);

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('gambar_232112')) {
            $imageName = time() . '.' . $request->gambar_232112->extension();
            $request->gambar_232112->move(public_path('images/lapangan'), $imageName);
            $data['gambar_232112'] = 'images/lapangan/' . $imageName;
        }

        // Set created_at timestamp
        $data['created_at_232112'] = now();

        Lapangan::create($data);

        return redirect()->route('admin.fields')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    public function editField($id)
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        $field = Lapangan::findOrFail($id);

        return view('admin.fields.edit', [
            'user' => Session::get('user'),
            'field' => $field
        ]);
    }

    public function updateField(Request $request, $id)
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        $request->validate([
            'nama_lapangan_232112' => 'required|string|max:255',
            'jenis_lapangan_232112' => 'required|string|max:100',
            'harga_per_jam_232112' => 'required|numeric|min:0',
            'kapasitas_232112' => 'required|integer|min:1',
            'deskripsi_232112' => 'nullable|string',
            'gambar_232112' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_232112' => 'required|in:active,inactive'
        ]);

        $field = Lapangan::findOrFail($id);
        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('gambar_232112')) {
            // Delete old image if exists
            if ($field->gambar_232112 && file_exists(public_path($field->gambar_232112))) {
                unlink(public_path($field->gambar_232112));
            }

            $imageName = time() . '.' . $request->gambar_232112->extension();
            $request->gambar_232112->move(public_path('images/lapangan'), $imageName);
            $data['gambar_232112'] = 'images/lapangan/' . $imageName;
        }

        // Update timestamp
        $data['updated_at_232112'] = now();

        $field->update($data);

        return redirect()->route('admin.fields')->with('success', 'Lapangan berhasil diperbarui!');
    }

    public function deleteField($id)
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        $field = Lapangan::findOrFail($id);

        // Check if field has active reservations
        $activeReservations = Reservasi::where('lapangan_id_232112', $id)
            ->whereIn('status_reservasi_232112', ['pending', 'confirmed'])
            ->count();

        if ($activeReservations > 0) {
            return redirect()->route('admin.fields')
                ->with('error', 'Tidak dapat menghapus lapangan yang memiliki reservasi aktif. Ada ' . $activeReservations . ' reservasi aktif.');
        }

        // Delete field image if exists
        if ($field->gambar_232112 && file_exists(public_path($field->gambar_232112))) {
            unlink(public_path($field->gambar_232112));
        }

        $field->delete();

        return redirect()->route('admin.fields')->with('success', 'Lapangan berhasil dihapus!');
    }

    public function updateFieldStatus(Request $request, $id)
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $field = Lapangan::findOrFail($id);
        $field->status_232112 = $request->status;
        $field->save();

        return response()->json(['success' => true, 'message' => 'Status lapangan berhasil diperbarui']);
    }

    public function users()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        $users = UserLegacy::where('role_232112', 'user')
            ->orderBy('created_at_232112', 'desc')
            ->get();

        return view('admin.users.index', [
            'user' => Session::get('user'),
            'users' => $users
        ]);
    }

    public function payments()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        $payments = Pembayaran::with(['reservasi.lapangan'])
            ->orderBy('tanggal_pembayaran_232112', 'desc')
            ->paginate(20);

        return view('admin.payments.index', [
            'user' => Session::get('user'),
            'payments' => $payments
        ]);
    }

    public function reports()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        // Monthly revenue for current year
        $monthlyRevenue = [];
        for ($month = 1; $month <= 12; $month++) {
            $revenue = Pembayaran::where('status_pembayaran_232112', 'paid')
                ->whereMonth('tanggal_pembayaran_232112', $month)
                ->whereYear('tanggal_pembayaran_232112', Carbon::now()->year)
                ->sum('jumlah_pembayaran_232112');
            $monthlyRevenue[] = $revenue;
        }

        // Field usage statistics
        $fieldUsage = Lapangan::withCount(['reservasi' => function ($query) {
            $query->whereYear('tanggal_reservasi_232112', Carbon::now()->year);
        }])->get();

        return view('admin.reports.index', [
            'user' => Session::get('user'),
            'monthlyRevenue' => $monthlyRevenue,
            'fieldUsage' => $fieldUsage
        ]);
    }

    public function updateReservationStatus(Request $request, $id)
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $reservation = Reservasi::findOrFail($id);
        $reservation->status_232112 = $request->status;
        $reservation->save();

        // Create notification for user
        Notifikasi::create([
            'user_id_232112' => $reservation->user_id_232112,
            'judul_232112' => 'Status Reservasi Diperbarui',
            'pesan_232112' => "Status reservasi {$reservation->kode_booking_232112} telah diperbarui menjadi {$request->status}",
            'tipe_232112' => 'reservation_update',
            'status_232112' => 'unread'
        ]);

        return response()->json(['success' => true, 'message' => 'Status reservasi berhasil diperbarui']);
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,paid,rejected'
        ]);

        $payment = Pembayaran::findOrFail($id);
        $payment->status_pembayaran_232112 = $request->status;
        $payment->verified_by_232112 = Session::get('user')['id'];
        $payment->save();

        // Create notification for user
        Notifikasi::create([
            'user_id_232112' => $payment->reservasi->user_id_232112,
            'judul_232112' => 'Status Pembayaran Diperbarui',
            'pesan_232112' => "Status pembayaran untuk reservasi {$payment->reservasi->kode_booking_232112} telah diperbarui menjadi {$request->status}",
            'tipe_232112' => 'payment_update',
            'status_232112' => 'unread'
        ]);

        return response()->json(['success' => true, 'message' => 'Status pembayaran berhasil diperbarui']);
    }
}

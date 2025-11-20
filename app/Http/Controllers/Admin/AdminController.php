<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $totalLapangan = Lapangan::count();
        $totalReservasi = Reservasi::count();
        $totalUser = User::where('role_232112', 'user')->count();
        $pendingReservasi = Reservasi::where('status_reservasi_232112', 'pending')->count();

        $recentReservasi = Reservasi::with(['user', 'lapangan'])
            ->orderBy('created_at_232112', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalLapangan',
            'totalReservasi',
            'totalUser',
            'pendingReservasi',
            'recentReservasi'
        ));
    }

    public function lapanganIndex()
    {
        $lapangan = Lapangan::orderBy('created_at_232112', 'desc')->paginate(10);
        return view('admin.lapangan.index', compact('lapangan'));
    }

    public function lapanganCreate()
    {
        return view('admin.lapangan.create');
    }

    public function lapanganStore(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:100',
            'jenis_lapangan' => 'required|in:futsal,badminton,sepak bola,basket,voli,tenis,bulu tangkis',
            'harga_per_jam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        $data = [
            'nama_lapangan_232112' => $request->nama_lapangan,
            'jenis_lapangan_232112' => $request->jenis_lapangan,
            'harga_per_jam_232112' => $request->harga_per_jam,
            'kapasitas_232112' => $request->kapasitas,
            'deskripsi_232112' => $request->deskripsi,
            'status_232112' => $request->status,
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/lapangan'), $filename);
            $data['gambar_232112'] = 'images/lapangan/' . $filename;
        }

        Lapangan::create($data);

        return redirect()->route('admin.lapangan.index')
            ->with('success', 'Lapangan berhasil ditambahkan');
    }

    public function reservasiIndex()
    {
        $reservasi = Reservasi::with(['user', 'lapangan'])
            ->orderBy('created_at_232112', 'desc')
            ->paginate(15);

        return view('admin.reservasi.index', compact('reservasi'));
    }

    public function reservasiUpdate(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $oldStatus = $reservasi->status_reservasi_232112;
        $newStatus = $request->status;

        $reservasi->update([
            'status_reservasi_232112' => $newStatus,
        ]);

        // Update payment status based on reservation status
        $pembayaran = $reservasi->pembayaran;
        if ($pembayaran) {
            $paymentStatus = $this->getPaymentStatusFromReservationStatus($newStatus);
            $pembayaran->update([
                'status_pembayaran_232112' => $paymentStatus,
                'tanggal_pembayaran_232112' => $newStatus === 'completed' ? now() : $pembayaran->tanggal_pembayaran_232112,
            ]);
        }

        return redirect()->back()->with('success', 'Status reservasi berhasil diupdate');
    }

    private function getPaymentStatusFromReservationStatus($reservationStatus)
    {
        // Define mapping between reservation status and payment status
        $statusMap = [
            'pending' => 'pending',
            'confirmed' => 'paid',      // When confirmed, payment is considered paid
            'completed' => 'paid',      // When completed, payment is paid
            'cancelled' => 'failed',    // When cancelled, payment is failed
        ];

        return $statusMap[$reservationStatus] ?? 'pending';
    }

    public function lapanganEdit($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function lapanganUpdate(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);

        $request->validate([
            'nama_lapangan' => 'required|string|max:100',
            'jenis_lapangan' => 'required|in:futsal,badminton,sepak bola,basket,voli,tenis,bulu tangkis',
            'harga_per_jam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        $data = [
            'nama_lapangan_232112' => $request->nama_lapangan,
            'jenis_lapangan_232112' => $request->jenis_lapangan,
            'harga_per_jam_232112' => $request->harga_per_jam,
            'kapasitas_232112' => $request->kapasitas,
            'deskripsi_232112' => $request->deskripsi,
            'status_232112' => $request->status,
        ];

        if ($request->hasFile('gambar')) {
            // Delete old image if it exists
            if ($lapangan->gambar_232112 && file_exists(public_path($lapangan->gambar_232112))) {
                unlink(public_path($lapangan->gambar_232112));
            }

            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/lapangan'), $filename);
            $data['gambar_232112'] = 'images/lapangan/' . $filename;
        }

        $lapangan->update($data);

        return redirect()->route('admin.lapangan.index')
            ->with('success', 'Lapangan berhasil diperbarui');
    }

    public function lapanganDelete(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);

        // Delete image file if it exists
        if ($lapangan->gambar_232112 && file_exists(public_path($lapangan->gambar_232112))) {
            unlink(public_path($lapangan->gambar_232112));
        }

        $lapangan->delete();

        return redirect()->route('admin.lapangan.index')
            ->with('success', 'Lapangan berhasil dihapus');
    }

    public function report()
    {
        // Get basic statistics for the reporting page
        $totalReservasi = Reservasi::count();
        // Include both confirmed and completed reservations for income calculation
        $totalPendapatan = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->sum('total_harga_232112');
        $totalPendapatanBulanIni = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->whereMonth('created_at_232112', now()->month)
            ->whereYear('created_at_232112', now()->year)
            ->sum('total_harga_232112');
        $totalReservasiBulanIni = Reservasi::whereMonth('created_at_232112', now()->month)
            ->whereYear('created_at_232112', now()->year)
            ->count();

        return view('admin.report.index', compact(
            'totalReservasi',
            'totalPendapatan',
            'totalPendapatanBulanIni',
            'totalReservasiBulanIni'
        ));
    }

    public function reportData()
    {
        // Get data for charts - last 12 months income
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->format('M Y');

            $income = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                ->whereYear('created_at_232112', $month->year)
                ->whereMonth('created_at_232112', $month->month)
                ->sum('total_harga_232112');

            $reservasiCount = Reservasi::whereYear('created_at_232112', $month->year)
                ->whereMonth('created_at_232112', $month->month)
                ->count();

            $chartData[] = [
                'month' => $monthName,
                'income' => $income,
                'reservasi' => $reservasiCount
            ];
        }

        // Get top lapangan by income
        $topLapangan = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->join('lapangan_232112', 'reservasi_232112.lapangan_id_232112', '=', 'lapangan_232112.lapangan_id_232112')
            ->selectRaw('lapangan_232112.nama_lapangan_232112, SUM(reservasi_232112.total_harga_232112) as total_income')
            ->groupBy('lapangan_232112.lapangan_id_232112', 'lapangan_232112.nama_lapangan_232112')
            ->orderByDesc('total_income')
            ->take(5)
            ->get();

        return response()->json([
            'monthlyData' => $chartData,
            'topLapangan' => $topLapangan
        ]);
    }

    public function exportExcel()
    {
        return Excel::download(new \App\Exports\ReservasiExport, 'Laporan_Reservasi_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportPdf()
    {
        // Get all reservations with related data for export
        $reservasi = Reservasi::with(['user', 'lapangan'])
            ->orderByDesc('created_at_232112')
            ->get();

        // Generate PDF using dompdf with landscape orientation
        $pdf = \PDF::loadView('admin.report.pdf', ['reservasi' => $reservasi])->setPaper('a4', 'landscape');
        return $pdf->download('Laporan_Reservasi_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
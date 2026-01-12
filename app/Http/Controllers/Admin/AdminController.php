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
            'jenis_lapangan' => 'required|in:futsal,badminton,tenis,padel',
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
            'jenis_lapangan' => 'required|in:futsal,badminton,tenis,padel',
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

    public function report(Request $request)
    {
        // Get date range, period type, and report type from request
        $reportType = $request->input('report_type', 'general'); // general, daily, monthly, yearly
        $periodType = $request->input('period_type', 'all'); // all, daily, weekly, monthly, yearly
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // For specific report types, adjust period type automatically
        if ($reportType === 'daily' && $periodType === 'all') {
            $periodType = 'daily';
        } elseif ($reportType === 'monthly' && $periodType === 'all') {
            $periodType = 'monthly';
        } elseif ($reportType === 'yearly' && $periodType === 'all') {
            $periodType = 'yearly';
        }

        // Base query for reservations
        $baseQuery = Reservasi::query();

        // Apply date range filter if provided
        if ($startDate && $endDate) {
            // If both start and end date are provided, use the date range
            $baseQuery->whereBetween('tanggal_reservasi_232112', [$startDate, $endDate]);
        } elseif ($startDate) {
            // If only start date is provided, use from start date to now
            $baseQuery->whereDate('tanggal_reservasi_232112', '>=', $startDate);
        } elseif ($endDate) {
            // If only end date is provided, use from beginning to end date
            $baseQuery->whereDate('tanggal_reservasi_232112', '<=', $endDate);
        } elseif ($periodType !== 'all') {
            // Apply period type filter only if no custom date range is specified
            switch ($periodType) {
                case 'daily':
                    $baseQuery->whereDate('tanggal_reservasi_232112', today());
                    break;
                case 'weekly':
                    $baseQuery->whereBetween('tanggal_reservasi_232112', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'monthly':
                    $baseQuery->whereMonth('tanggal_reservasi_232112', now()->month)
                              ->whereYear('tanggal_reservasi_232112', now()->year);
                    break;
                case 'yearly':
                    $baseQuery->whereYear('tanggal_reservasi_232112', now()->year);
                    break;
            }
        }

        // Get basic statistics with applied filters
        $totalReservasi = $baseQuery->count();
        $totalPendapatan = $baseQuery->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->sum('total_harga_232112');

        // Set appropriate label based on filters applied
        if ($startDate && $endDate) {
            // Custom date range
            $currentPeriodLabel = 'Periode ' . \Carbon\Carbon::parse($startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($endDate)->format('d M Y');
        } elseif ($startDate) {
            // Only start date provided
            $currentPeriodLabel = 'Sejak ' . \Carbon\Carbon::parse($startDate)->format('d M Y');
        } elseif ($endDate) {
            // Only end date provided
            $currentPeriodLabel = 'Sampai ' . \Carbon\Carbon::parse($endDate)->format('d M Y');
        } else {
            // Period type filter applied
            switch ($periodType) {
                case 'daily':
                    $currentPeriodLabel = 'Hari Ini';
                    break;
                case 'weekly':
                    $currentPeriodLabel = 'Minggu Ini';
                    break;
                case 'monthly':
                    $currentPeriodLabel = 'Bulan Ini';
                    break;
                case 'yearly':
                    $currentPeriodLabel = 'Tahun Ini';
                    break;
                default:
                    $currentPeriodLabel = 'Semua Waktu';
                    break;
            }
        }

        // Pass current period type to the view
        $currentPeriodType = $periodType;

        return view('admin.report.index', compact(
            'totalReservasi',
            'totalPendapatan',
            'currentPeriodType',
            'currentPeriodLabel',
            'startDate',
            'endDate',
            'reportType'
        ) + [
            'totalPendapatanCurrentPeriod' => $totalPendapatan, // Using the same total for consistency
            'totalReservasiCurrentPeriod' => $totalReservasi, // Using the same total for consistency
        ]);
    }

    public function reportData(Request $request)
    {
        // Get date range and period type from request
        $periodType = $request->input('period_type', 'monthly'); // default to monthly
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $chartData = [];

        // Base query for reservations
        $baseQuery = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed']);

        // Apply date range filter if provided
        if ($startDate && $endDate) {
            $baseQuery->whereBetween('tanggal_reservasi_232112', [$startDate, $endDate]);
        } elseif ($startDate) {
            // If only start date is provided, use from start date to now
            $baseQuery->whereDate('tanggal_reservasi_232112', '>=', $startDate);
        } elseif ($endDate) {
            // If only end date is provided, use from beginning to end date
            $baseQuery->whereDate('tanggal_reservasi_232112', '<=', $endDate);
        } elseif ($periodType !== 'all') {
            // Apply period type filter only if no custom date range is specified
            switch ($periodType) {
                case 'daily':
                    $baseQuery->whereDate('tanggal_reservasi_232112', today());
                    break;
                case 'weekly':
                    $baseQuery->whereBetween('tanggal_reservasi_232112', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'monthly':
                    $baseQuery->whereMonth('tanggal_reservasi_232112', now()->month)
                              ->whereYear('tanggal_reservasi_232112', now()->year);
                    break;
                case 'yearly':
                    $baseQuery->whereYear('tanggal_reservasi_232112', now()->year);
                    break;
            }
        }

        // Determine the chart type and generate appropriate data based on filters applied
        // If custom date range is provided, determine the best visualization based on date range
        if ($startDate && $endDate) {
            $start = \Carbon\Carbon::parse($startDate);
            $end = \Carbon\Carbon::parse($endDate);
            $diffInDays = $end->diffInDays($start);

            if ($diffInDays <= 1) {
                // Less than 2 days: show hourly data
                for ($hour = 0; $hour < 24; $hour++) {
                    $hourStart = $start->copy()->setHour($hour)->setMinute(0)->setSecond(0);
                    $hourEnd = $hourStart->copy()->addHour();

                    $income = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                        ->whereBetween('tanggal_reservasi_232112', [$hourStart, $hourEnd])
                        ->sum('total_harga_232112');

                    $reservasiCount = Reservasi::whereBetween('tanggal_reservasi_232112', [$hourStart, $hourEnd])
                        ->count();

                    $chartData[] = [
                        'label' => $hourStart->format('H:00'),
                        'income' => $income,
                        'reservasi' => $reservasiCount
                    ];
                }
            } elseif ($diffInDays <= 31) {
                // Less than 32 days: show daily data
                $current = $start->copy();
                while ($current->lessThanOrEqualTo($end)) {
                    $date = $current->copy();

                    $income = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                        ->whereDate('tanggal_reservasi_232112', $date)
                        ->sum('total_harga_232112');

                    $reservasiCount = Reservasi::whereDate('tanggal_reservasi_232112', $date)
                        ->count();

                    $chartData[] = [
                        'label' => $date->format('d'),
                        'day' => $date->format('d M'),
                        'income' => $income,
                        'reservasi' => $reservasiCount
                    ];

                    $current->addDay();
                }
            } else {
                // More than 31 days: show monthly data
                $current = $start->copy()->startOfMonth();
                $endMonth = $end->copy()->endOfMonth();

                while ($current->lessThanOrEqualTo($endMonth)) {
                    $month = $current->copy();

                    $income = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                        ->whereYear('tanggal_reservasi_232112', $month->year)
                        ->whereMonth('tanggal_reservasi_232112', $month->month)
                        ->sum('total_harga_232112');

                    $reservasiCount = Reservasi::whereYear('tanggal_reservasi_232112', $month->year)
                        ->whereMonth('tanggal_reservasi_232112', $month->month)
                        ->count();

                    $chartData[] = [
                        'label' => $month->format('M'),
                        'month' => $month->format('F Y'),
                        'income' => $income,
                        'reservasi' => $reservasiCount
                    ];

                    $current->addMonth();
                }
            }
        } else {
            // Generate chart data based on the selected period type
            switch ($periodType) {
                case 'daily':
                    // Get hourly income data for today - ensure all 24 hours are represented
                    // When showing income per hour, we calculate based on reservations made for that date
                    for ($hour = 0; $hour < 24; $hour++) {
                        $hourStart = today()->setHour($hour)->setMinute(0)->setSecond(0);
                        $hourEnd = $hourStart->copy()->addHour();

                        // Find reservations that were made for today's date and start in this hour
                        $income = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                            ->whereDate('tanggal_reservasi_232112', today())
                            ->whereTime('waktu_mulai_232112', '>=', $hourStart->format('H:i'))
                            ->whereTime('waktu_mulai_232112', '<', $hourEnd->format('H:i'))
                            ->sum('total_harga_232112');

                        $reservasiCount = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                            ->whereDate('tanggal_reservasi_232112', today())
                            ->whereTime('waktu_mulai_232112', '>=', $hourStart->format('H:i'))
                            ->whereTime('waktu_mulai_232112', '<', $hourEnd->format('H:i'))
                            ->count();

                        $chartData[] = [
                            'label' => $hourStart->format('H:00'),
                            'income' => $income,
                            'reservasi' => $reservasiCount
                        ];
                    }
                    break;

                case 'weekly':
                    // Get daily income data for the week - ensure all 7 days are represented
                    $startOfWeek = now()->startOfWeek();
                    for ($i = 0; $i < 7; $i++) {
                        $date = $startOfWeek->copy()->addDays($i);

                        $income = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                            ->whereDate('tanggal_reservasi_232112', $date)
                            ->sum('total_harga_232112');

                        $reservasiCount = Reservasi::whereDate('tanggal_reservasi_232112', $date)
                            ->count();

                        $chartData[] = [
                            'label' => $date->format('D'),
                            'day' => $date->format('d M'),
                            'income' => $income,
                            'reservasi' => $reservasiCount
                        ];
                    }
                    break;

                case 'yearly':
                    // Get monthly income data for the year - ensure all 12 months are represented
                    for ($i = 0; $i < 12; $i++) {
                        $month = now()->startOfYear()->addMonths($i);

                        $income = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                            ->whereYear('tanggal_reservasi_232112', $month->year)
                            ->whereMonth('tanggal_reservasi_232112', $month->month)
                            ->sum('total_harga_232112');

                        $reservasiCount = Reservasi::whereYear('tanggal_reservasi_232112', $month->year)
                            ->whereMonth('tanggal_reservasi_232112', $month->month)
                            ->count();

                        $chartData[] = [
                            'label' => $month->format('M'),
                            'month' => $month->format('F Y'),
                            'income' => $income,
                            'reservasi' => $reservasiCount
                        ];
                    }
                    break;

                default: // monthly
                case 'monthly':
                    // Get daily income data for the month - ensure all days are represented
                    $daysInMonth = now()->daysInMonth;
                    for ($i = 1; $i <= $daysInMonth; $i++) {
                        $date = now()->startOfMonth()->addDays($i - 1);

                        $income = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                            ->whereDate('tanggal_reservasi_232112', $date)
                            ->sum('total_harga_232112');

                        $reservasiCount = Reservasi::whereDate('tanggal_reservasi_232112', $date)
                            ->count();

                        $chartData[] = [
                            'label' => $date->format('d'),
                            'day' => $date->format('d M'),
                            'income' => $income,
                            'reservasi' => $reservasiCount
                        ];
                    }
                    break;
            }
        }

        // Get top lapangan by income based on the same filters
        $topLapanganQuery = Reservasi::whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->join('lapangan_232112', 'reservasi_232112.lapangan_id_232112', '=', 'lapangan_232112.lapangan_id_232112')
            ->selectRaw('lapangan_232112.nama_lapangan_232112, SUM(reservasi_232112.total_harga_232112) as total_income')
            ->groupBy('lapangan_232112.lapangan_id_232112', 'lapangan_232112.nama_lapangan_232112')
            ->orderByDesc('total_income')
            ->take(5);

        // Apply same date filters to top lapangan query
        if ($startDate && $endDate) {
            $topLapanganQuery->whereBetween('reservasi.tanggal_reservasi_232112', [$startDate, $endDate]);
        } elseif ($startDate) {
            $topLapanganQuery->whereDate('reservasi.tanggal_reservasi_232112', '>=', $startDate);
        } elseif ($endDate) {
            $topLapanganQuery->whereDate('reservasi.tanggal_reservasi_232112', '<=', $endDate);
        } elseif ($periodType !== 'all') {
            switch ($periodType) {
                case 'daily':
                    $topLapanganQuery->whereDate('reservasi.tanggal_reservasi_232112', today());
                    break;
                case 'weekly':
                    $topLapanganQuery->whereBetween('reservasi.tanggal_reservasi_232112', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'monthly':
                    $topLapanganQuery->whereMonth('reservasi.tanggal_reservasi_232112', now()->month)
                                     ->whereYear('reservasi.tanggal_reservasi_232112', now()->year);
                    break;
                case 'yearly':
                    $topLapanganQuery->whereYear('reservasi.tanggal_reservasi_232112', now()->year);
                    break;
            }
        }

        $topLapangan = $topLapanganQuery->get();

        return response()->json([
            'periodType' => $periodType,
            'chartData' => $chartData,
            'topLapangan' => $topLapangan
        ]);
    }

    public function exportExcel(Request $request)
    {
        // Get date range and period type from request
        $periodType = $request->input('period_type', 'all'); // all, daily, weekly, monthly, yearly
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $reservasiQuery = Reservasi::with(['user', 'lapangan']);

        // Apply date range filter if provided
        // Use tanggal_reservasi_232112 (reservation date) instead of created_at_232112 for better accuracy
        if ($startDate && $endDate) {
            $reservasiQuery->whereBetween('tanggal_reservasi_232112', [$startDate, $endDate]);
        } elseif ($startDate) {
            // If only start date is provided, use from start date to now
            $reservasiQuery->whereDate('tanggal_reservasi_232112', '>=', $startDate);
        } elseif ($endDate) {
            // If only end date is provided, use from beginning to end date
            $reservasiQuery->whereDate('tanggal_reservasi_232112', '<=', $endDate);
        } elseif ($periodType !== 'all') {
            // Apply period type filter only if no custom date range is specified
            switch ($periodType) {
                case 'daily':
                    $reservasiQuery->whereDate('tanggal_reservasi_232112', today());
                    break;
                case 'weekly':
                    $reservasiQuery->whereBetween('tanggal_reservasi_232112', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'monthly':
                    $reservasiQuery->whereMonth('tanggal_reservasi_232112', now()->month)
                                   ->whereYear('tanggal_reservasi_232112', now()->year);
                    break;
                case 'yearly':
                    $reservasiQuery->whereYear('tanggal_reservasi_232112', now()->year);
                    break;
            }
        }

        $reservasi = $reservasiQuery->orderByDesc('created_at_232112')->get();

        // Calculate total income for the period
        $totalPendapatan = $reservasi->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->sum('total_harga_232112');

        // Create export with filtered data
        $export = new class($reservasi, $totalPendapatan, $periodType, $startDate, $endDate) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle
        {
            private $reservasi;
            private $totalPendapatan;
            private $periodType;
            private $startDate;
            private $endDate;

            public function __construct($reservasi, $totalPendapatan, $periodType, $startDate, $endDate)
            {
                $this->reservasi = $reservasi;
                $this->totalPendapatan = $totalPendapatan;
                $this->periodType = $periodType;
                $this->startDate = $startDate;
                $this->endDate = $endDate;
            }

            public function headings(): array
            {
                return [
                    'ID Reservasi',
                    'Nama User',
                    'Email User',
                    'Nama Lapangan',
                    'Jenis Lapangan',
                    'Tanggal Reservasi',
                    'Waktu Mulai',
                    'Waktu Selesai',
                    'Total Harga',
                    'Status Reservasi',
                    'Catatan',
                    'Tanggal Dibuat'
                ];
            }

            public function title(): string
            {
                // Determine the appropriate period label based on provided parameters
                if ($this->startDate && $this->endDate) {
                    // Custom date range
                    $periode = 'Periode ' . \Carbon\Carbon::parse($this->startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('d M Y');
                } elseif ($this->startDate) {
                    // Only start date provided
                    $periode = 'Sejak ' . \Carbon\Carbon::parse($this->startDate)->format('d M Y');
                } elseif ($this->endDate) {
                    // Only end date provided
                    $periode = 'Sampai ' . \Carbon\Carbon::parse($this->endDate)->format('d M Y');
                } else {
                    // Period type filter applied
                    switch ($this->periodType) {
                        case 'daily':
                            $periode = 'Harian (' . ($this->startDate ? \Carbon\Carbon::parse($this->startDate)->format('d M Y') : today()->format('d M Y')) . ')';
                            break;
                        case 'weekly':
                            $startDateFormatted = $this->startDate ? \Carbon\Carbon::parse($this->startDate)->format('d M Y') : now()->startOfWeek()->format('d M Y');
                            $endDateFormatted = $this->endDate ? \Carbon\Carbon::parse($this->endDate)->format('d M Y') : now()->endOfWeek()->format('d M Y');
                            $periode = 'Mingguan (' . $startDateFormatted . ' - ' . $endDateFormatted . ')';
                            break;
                        case 'monthly':
                            $startDateFormatted = $this->startDate ? \Carbon\Carbon::parse($this->startDate)->format('d M Y') : now()->startOfMonth()->format('d M Y');
                            $endDateFormatted = $this->endDate ? \Carbon\Carbon::parse($this->endDate)->format('d M Y') : now()->endOfMonth()->format('d M Y');
                            $periode = 'Bulanan (' . $startDateFormatted . ' - ' . $endDateFormatted . ')';
                            break;
                        case 'yearly':
                            $tahun = $this->startDate ? \Carbon\Carbon::parse($this->startDate)->format('Y') : now()->format('Y');
                            $periode = 'Tahunan (' . $tahun . ')';
                            break;
                        default:
                            $periode = 'Semua Waktu';
                            break;
                    }
                }

                return 'Laporan Pendapatan (' . $periode . ')';
            }

            public function collection()
            {
                return collect($this->reservasi)->map(function ($item) {
                    return [
                        $item->reservasi_id_232112,
                        $item->user->nama_232112,
                        $item->user->email_232112,
                        $item->lapangan->nama_lapangan_232112,
                        $item->lapangan->jenis_lapangan_232112,
                        $item->tanggal_reservasi_232112,
                        $item->waktu_mulai_232112,
                        $item->waktu_selesai_232112,
                        $item->total_harga_232112,
                        $item->status_reservasi_232112,
                        $item->catatan_232112,
                        $item->created_at_232112,
                    ];
                });
            }
        };

        return Excel::download($export, 'Laporan_Reservasi_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        // Get date range and period type from request
        $periodType = $request->input('period_type', 'all'); // all, daily, weekly, monthly, yearly
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $reservasiQuery = Reservasi::with(['user', 'lapangan']);

        // Apply date range filter if provided
        // Use tanggal_reservasi_232112 (reservation date) instead of created_at_232112 for better accuracy
        if ($startDate && $endDate) {
            $reservasiQuery->whereBetween('tanggal_reservasi_232112', [$startDate, $endDate]);
        } elseif ($startDate) {
            // If only start date is provided, use from start date to now
            $reservasiQuery->whereDate('tanggal_reservasi_232112', '>=', $startDate);
        } elseif ($endDate) {
            // If only end date is provided, use from beginning to end date
            $reservasiQuery->whereDate('tanggal_reservasi_232112', '<=', $endDate);
        } elseif ($periodType !== 'all') {
            // Apply period type filter only if no custom date range is specified
            switch ($periodType) {
                case 'daily':
                    $reservasiQuery->whereDate('tanggal_reservasi_232112', today());
                    break;
                case 'weekly':
                    $reservasiQuery->whereBetween('tanggal_reservasi_232112', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'monthly':
                    $reservasiQuery->whereMonth('tanggal_reservasi_232112', now()->month)
                                   ->whereYear('tanggal_reservasi_232112', now()->year);
                    break;
                case 'yearly':
                    $reservasiQuery->whereYear('tanggal_reservasi_232112', now()->year);
                    break;
            }
        }

        $reservasi = $reservasiQuery->orderByDesc('created_at_232112')->get();

        // Calculate total income for the period
        $totalPendapatan = $reservasi->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->sum('total_harga_232112');

        // Determine the appropriate period label based on provided parameters
        if ($startDate && $endDate) {
            // Custom date range
            $periodeInfo = 'Periode ' . \Carbon\Carbon::parse($startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($endDate)->format('d M Y');
        } elseif ($startDate) {
            // Only start date provided
            $periodeInfo = 'Sejak ' . \Carbon\Carbon::parse($startDate)->format('d M Y');
        } elseif ($endDate) {
            // Only end date provided
            $periodeInfo = 'Sampai ' . \Carbon\Carbon::parse($endDate)->format('d M Y');
        } else {
            // Period type filter applied
            switch ($periodType) {
                case 'daily':
                    $periodeInfo = 'Harian (' . ($startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : today()->format('d M Y')) . ')';
                    break;
                case 'weekly':
                    $startDateFormatted = $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : now()->startOfWeek()->format('d M Y');
                    $endDateFormatted = $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : now()->endOfWeek()->format('d M Y');
                    $periodeInfo = 'Mingguan (' . $startDateFormatted . ' - ' . $endDateFormatted . ')';
                    break;
                case 'monthly':
                    $startDateFormatted = $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : now()->startOfMonth()->format('d M Y');
                    $endDateFormatted = $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : now()->endOfMonth()->format('d M Y');
                    $periodeInfo = 'Bulanan (' . $startDateFormatted . ' - ' . $endDateFormatted . ')';
                    break;
                case 'yearly':
                    $tahun = $startDate ? \Carbon\Carbon::parse($startDate)->format('Y') : now()->format('Y');
                    $periodeInfo = 'Tahunan (' . $tahun . ')';
                    break;
                default:
                    $periodeInfo = 'Semua Waktu';
                    break;
            }
        }

        // Generate PDF using dompdf with landscape orientation
        $pdf = \PDF::loadView('admin.report.pdf', [
            'reservasi' => $reservasi,
            'totalPendapatan' => $totalPendapatan,
            'periodeInfo' => $periodeInfo
        ])->setPaper('a4', 'landscape');
        return $pdf->download('Laporan_Reservasi_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    public function previewPdf(Request $request)
    {
        // Get date range and period type from request
        $periodType = $request->input('period_type', 'all'); // all, daily, weekly, monthly, yearly
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $reservasiQuery = Reservasi::with(['user', 'lapangan']);

        // Apply date range filter if provided
        // Use tanggal_reservasi_232112 (reservation date) instead of created_at_232112 for better accuracy
        if ($startDate && $endDate) {
            $reservasiQuery->whereBetween('tanggal_reservasi_232112', [$startDate, $endDate]);
        } elseif ($startDate) {
            // If only start date is provided, use from start date to now
            $reservasiQuery->whereDate('tanggal_reservasi_232112', '>=', $startDate);
        } elseif ($endDate) {
            // If only end date is provided, use from beginning to end date
            $reservasiQuery->whereDate('tanggal_reservasi_232112', '<=', $endDate);
        } elseif ($periodType !== 'all') {
            // Apply period type filter only if no custom date range is specified
            switch ($periodType) {
                case 'daily':
                    $reservasiQuery->whereDate('tanggal_reservasi_232112', today());
                    break;
                case 'weekly':
                    $reservasiQuery->whereBetween('tanggal_reservasi_232112', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'monthly':
                    $reservasiQuery->whereMonth('tanggal_reservasi_232112', now()->month)
                                   ->whereYear('tanggal_reservasi_232112', now()->year);
                    break;
                case 'yearly':
                    $reservasiQuery->whereYear('tanggal_reservasi_232112', now()->year);
                    break;
            }
        }

        $reservasi = $reservasiQuery->orderByDesc('created_at_232112')->get();

        // Calculate total income for the period
        $totalPendapatan = $reservasi->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->sum('total_harga_232112');

        // Determine the appropriate period label based on provided parameters
        if ($startDate && $endDate) {
            // Custom date range
            $periodeInfo = 'Periode ' . \Carbon\Carbon::parse($startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($endDate)->format('d M Y');
        } elseif ($startDate) {
            // Only start date provided
            $periodeInfo = 'Sejak ' . \Carbon\Carbon::parse($startDate)->format('d M Y');
        } elseif ($endDate) {
            // Only end date provided
            $periodeInfo = 'Sampai ' . \Carbon\Carbon::parse($endDate)->format('d M Y');
        } else {
            // Period type filter applied
            switch ($periodType) {
                case 'daily':
                    $periodeInfo = 'Harian (' . ($startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : today()->format('d M Y')) . ')';
                    break;
                case 'weekly':
                    $startDateFormatted = $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : now()->startOfWeek()->format('d M Y');
                    $endDateFormatted = $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : now()->endOfWeek()->format('d M Y');
                    $periodeInfo = 'Mingguan (' . $startDateFormatted . ' - ' . $endDateFormatted . ')';
                    break;
                case 'monthly':
                    $startDateFormatted = $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : now()->startOfMonth()->format('d M Y');
                    $endDateFormatted = $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : now()->endOfMonth()->format('d M Y');
                    $periodeInfo = 'Bulanan (' . $startDateFormatted . ' - ' . $endDateFormatted . ')';
                    break;
                case 'yearly':
                    $tahun = $startDate ? \Carbon\Carbon::parse($startDate)->format('Y') : now()->format('Y');
                    $periodeInfo = 'Tahunan (' . $tahun . ')';
                    break;
                default:
                    $periodeInfo = 'Semua Waktu';
                    break;
            }
        }

        // Check if download parameter is present
        if ($request->has('download') && $request->input('download') == 'true') {
            // Generate PDF using dompdf with landscape orientation
            $pdf = \PDF::loadView('admin.report.pdf', [
                'reservasi' => $reservasi,
                'totalPendapatan' => $totalPendapatan,
                'periodeInfo' => $periodeInfo
            ])->setPaper('a4', 'landscape');
            return $pdf->download('Laporan_Reservasi_' . date('Y-m-d_H-i-s') . '.pdf');
        } else {
            return view('admin.report.pdf_preview', [
                'reservasi' => $reservasi,
                'totalPendapatan' => $totalPendapatan,
                'periodeInfo' => $periodeInfo,
                'periodType' => $periodType,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
        }
    }

    // User Management Methods
    public function usersIndex()
    {
        $users = User::orderBy('created_at_232112', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function usersCreate()
    {
        return view('admin.users.create');
    }

    public function usersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users_232112,email_232112',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'role' => 'required|in:user,admin',
        ]);

        $data = [
            'nama_232112' => $request->name,
            'email_232112' => $request->email,
            'password_232112' => bcrypt($request->password),
            'telepon_232112' => $request->phone,
            'alamat_232112' => $request->alamat,
            'role_232112' => $request->role,
            'email_verified_at_232112' => now(),
        ];

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }


    public function usersDelete($id)
    {
        $user = User::findOrFail($id);

        // Prevent deletion of current user
        if ($user->user_id_232112 == auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak bisa menghapus akun Anda sendiri');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }

    // New methods for daily, monthly, and yearly reports - redirect to main report page with appropriate parameters
    public function reportsSummary()
    {
        return redirect()->route('admin.report.index', ['report_type' => 'general']);
    }

    public function reportsDaily()
    {
        return redirect()->route('admin.report.index', ['report_type' => 'daily']);
    }

    public function reportsMonthly()
    {
        return redirect()->route('admin.report.index', ['report_type' => 'monthly']);
    }

    public function reportsYearly()
    {
        return redirect()->route('admin.report.index', ['report_type' => 'yearly']);
    }

    public function reportsFetch(Request $request)
    {
        $type = $request->input('type');
        $date = $request->input('date');
        $month = $request->input('month');
        $year = $request->input('year');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        try {
            switch ($type) {
                case 'daily':
                    $result = $this->getDailyReport($date, $startDate, $endDate);
                    break;
                case 'monthly':
                    $result = $this->getMonthlyReport($month, $startDate, $endDate);
                    break;
                case 'yearly':
                    $result = $this->getYearlyReport($year, $startDate, $endDate);
                    break;
                default:
                    return response()->json(['success' => false, 'message' => 'Invalid report type']);
            }

            return response()->json([
                'success' => true,
                'stats' => $result['stats'],
                'chartData' => $result['chartData']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching report data: ' . $e->getMessage()
            ]);
        }
    }

    private function getDailyReport($date = null, $startDate = null, $endDate = null)
    {
        // If both startDate and endDate are provided, use them as date range instead of single date
        if ($startDate && $endDate) {
            $reservasiQuery = Reservasi::whereBetween('tanggal_reservasi_232112', [$startDate, $endDate]);
            $dateLabel = 'Rentang Tanggal';
        } else {
            $date = $date ?? today()->format('Y-m-d');
            // Get reservations for the specific date
            $reservasiQuery = Reservasi::whereDate('tanggal_reservasi_232112', $date);
            $dateLabel = $date;
        }

        // Calculate stats
        $totalReservasi = $reservasiQuery->count();
        $totalIncome = $reservasiQuery->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->sum('total_harga_232112');
        $confirmedReservasi = $reservasiQuery
            ->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->count();

        // Calculate average duration (in hours)
        $avgDuration = 0;
        if ($totalReservasi > 0) {
            $reservasi = $reservasiQuery->get();
            $totalDuration = 0;

            foreach ($reservasi as $r) {
                $start = \Carbon\Carbon::parse($r->waktu_mulai_232112);
                $end = \Carbon\Carbon::parse($r->waktu_selesai_232112);
                $totalDuration += $end->diffInHours($start);
            }

            $avgDuration = $totalReservasi > 0 ? round($totalDuration / $totalReservasi, 1) : 0;
        }

        // For hourly chart, we need to aggregate by day if using date range, or by hour if single day
        $chartData = [];
        if ($startDate && $endDate) {
            // If date range is provided, aggregate by day
            $start = \Carbon\Carbon::parse($startDate);
            $end = \Carbon\Carbon::parse($endDate);

            while ($start->lessThanOrEqualTo($end)) {
                $currentDate = $start->copy();
                $dailyIncome = Reservasi::whereDate('tanggal_reservasi_232112', $currentDate)
                    ->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                    ->sum('total_harga_232112');

                $chartData[] = [
                    'label' => $currentDate->format('d M'),
                    'income' => $dailyIncome
                ];

                $start->addDay();
            }
        } else {
            // Generate hourly chart data for single date
            for ($hour = 0; $hour < 24; $hour++) {
                $hourStart = \Carbon\Carbon::parse($date)->setHour($hour)->setMinute(0)->setSecond(0);
                $hourEnd = $hourStart->copy()->addHour();

                $hourlyIncome = Reservasi::whereDate('tanggal_reservasi_232112', $date)
                    ->whereTime('waktu_mulai_232112', '>=', $hourStart->format('H:i:s'))
                    ->whereTime('waktu_mulai_232112', '<', $hourEnd->format('H:i:s'))
                    ->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                    ->sum('total_harga_232112');

                $chartData[] = [
                    'label' => $hourStart->format('H:00'),
                    'income' => $hourlyIncome
                ];
            }
        }

        return [
            'stats' => [
                'income' => $totalIncome,
                'reservations' => $totalReservasi,
                'confirmed' => $confirmedReservasi,
                'avg_duration' => $avgDuration . ' jam'
            ],
            'chartData' => [
                'labels' => array_column($chartData, 'label'),
                'income_data' => array_column($chartData, 'income')
            ]
        ];
    }

    private function getMonthlyReport($month = null, $startDate = null, $endDate = null)
    {
        // If both startDate and endDate are provided, use them as date range instead of single month
        if ($startDate && $endDate) {
            $reservasiQuery = Reservasi::whereBetween('tanggal_reservasi_232112', [$startDate, $endDate]);

            // Calculate stats for date range
            $totalReservasi = $reservasiQuery->count();
            $totalIncome = $reservasiQuery->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                ->sum('total_harga_232112');

            // Calculate days in range for daily avg
            $start = \Carbon\Carbon::parse($startDate);
            $end = \Carbon\Carbon::parse($endDate);
            $daysInRange = $start->diffInDays($end) + 1;
            $dailyAvg = $daysInRange > 0 ? $totalReservasi / $daysInRange : 0;

            // Find peak day in range
            $dailyStats = [];
            $peakDayIncome = 0;
            $peakDay = '';

            $current = $start->copy();
            while ($current->lessThanOrEqualTo($end)) {
                $currentDate = $current->copy();
                $dayIncome = Reservasi::whereDate('tanggal_reservasi_232112', $currentDate)
                    ->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                    ->sum('total_harga_232112');

                $dailyStats[] = [
                    'day' => $currentDate->format('d'),
                    'income' => $dayIncome
                ];

                if ($dayIncome > $peakDayIncome) {
                    $peakDayIncome = $dayIncome;
                    $peakDay = $currentDate->format('d F Y');
                }

                $current->addDay();
            }

            return [
                'stats' => [
                    'income' => $totalIncome,
                    'reservations' => $totalReservasi,
                    'daily_avg' => round($dailyAvg, 1),
                    'peak_day' => $peakDay
                ],
                'chartData' => [
                    'labels' => array_map(function($day) { return $day . ' '; }, range(1, min(31, count($dailyStats)))), // Just show day numbers
                    'income_data' => array_column($dailyStats, 'income')
                ]
            ];
        } else {
            // Original monthly report logic
            $date = $month ? \Carbon\Carbon::parse($month . '-01') : now();
            $year = $date->year;
            $monthNum = $date->month;
            $daysInMonth = $date->daysInMonth;

            // Get reservations for the specific month
            $reservasiQuery = Reservasi::whereYear('tanggal_reservasi_232112', $year)
                ->whereMonth('tanggal_reservasi_232112', $monthNum);

            // Calculate stats
            $totalReservasi = $reservasiQuery->count();
            $totalIncome = $reservasiQuery->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                ->sum('total_harga_232112');
            $dailyAvg = $totalReservasi / $daysInMonth;

            // Find peak day
            $dailyStats = [];
            $peakDayIncome = 0;
            $peakDay = '';

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = \Carbon\Carbon::create($year, $monthNum, $day);
                $dayIncome = Reservasi::whereDate('tanggal_reservasi_232112', $currentDate)
                    ->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                    ->sum('total_harga_232112');

                $dailyStats[] = [
                    'day' => $currentDate->format('d'),
                    'income' => $dayIncome
                ];

                if ($dayIncome > $peakDayIncome) {
                    $peakDayIncome = $dayIncome;
                    $peakDay = $currentDate->format('d F');
                }
            }

            return [
                'stats' => [
                    'income' => $totalIncome,
                    'reservations' => $totalReservasi,
                    'daily_avg' => round($dailyAvg, 1),
                    'peak_day' => $peakDay
                ],
                'chartData' => [
                    'labels' => array_map(function($day) { return $day . ' '; }, range(1, $daysInMonth)),
                    'income_data' => array_column($dailyStats, 'income')
                ]
            ];
        }
    }

    private function getYearlyReport($year = null, $startDate = null, $endDate = null)
    {
        // If both startDate and endDate are provided, use them as date range instead of single year
        if ($startDate && $endDate) {
            $reservasiQuery = Reservasi::whereBetween('tanggal_reservasi_232112', [$startDate, $endDate]);

            // Calculate stats for date range
            $totalReservasi = $reservasiQuery->count();
            $totalIncome = $reservasiQuery->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                ->sum('total_harga_232112');

            // Calculate months in range for monthly avg
            $start = \Carbon\Carbon::parse($startDate);
            $end = \Carbon\Carbon::parse($endDate);
            $monthsDiff = $start->diffInMonths($end) + 1; // Adding 1 to include both start and end months
            $monthlyAvg = $monthsDiff > 0 ? $totalReservasi / $monthsDiff : 0;

            // Find best month in range
            $monthlyStats = [];
            $bestMonthIncome = 0;
            $bestMonth = '';

            $current = $start->copy()->startOfMonth();
            $endMonth = $end->copy()->endOfMonth();

            while ($current->lessThanOrEqualTo($endMonth)) {
                $currentMonth = $current->copy();
                $monthIncome = Reservasi::whereYear('tanggal_reservasi_232112', $currentMonth->year)
                    ->whereMonth('tanggal_reservasi_232112', $currentMonth->month)
                    ->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                    ->sum('total_harga_232112');

                $monthName = $currentMonth->format('M');

                $monthlyStats[] = [
                    'month' => $monthName,
                    'income' => $monthIncome
                ];

                if ($monthIncome > $bestMonthIncome) {
                    $bestMonthIncome = $monthIncome;
                    $bestMonth = $currentMonth->format('F Y');
                }

                $current->addMonth();
            }

            return [
                'stats' => [
                    'income' => $totalIncome,
                    'reservations' => $totalReservasi,
                    'monthly_avg' => round($monthlyAvg, 1),
                    'best_month' => $bestMonth
                ],
                'chartData' => [
                    'labels' => array_column($monthlyStats, 'month'),
                    'income_data' => array_column($monthlyStats, 'income')
                ]
            ];
        } else {
            // Original yearly report logic
            $year = $year ?? now()->year;

            // Get reservations for the specific year
            $reservasiQuery = Reservasi::whereYear('tanggal_reservasi_232112', $year);

            // Calculate stats
            $totalReservasi = $reservasiQuery->count();
            $totalIncome = $reservasiQuery->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                ->sum('total_harga_232112');
            $monthlyAvg = $totalReservasi / 12;

            // Find best month
            $monthlyStats = [];
            $bestMonthIncome = 0;
            $bestMonth = '';

            for ($month = 1; $month <= 12; $month++) {
                $monthIncome = Reservasi::whereYear('tanggal_reservasi_232112', $year)
                    ->whereMonth('tanggal_reservasi_232112', $month)
                    ->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
                    ->sum('total_harga_232112');

                $monthName = \Carbon\Carbon::create($year, $month, 1)->format('M');

                $monthlyStats[] = [
                    'month' => $monthName,
                    'income' => $monthIncome
                ];

                if ($monthIncome > $bestMonthIncome) {
                    $bestMonthIncome = $monthIncome;
                    $bestMonth = \Carbon\Carbon::create($year, $month, 1)->format('F');
                }
            }

            return [
                'stats' => [
                    'income' => $totalIncome,
                    'reservations' => $totalReservasi,
                    'monthly_avg' => round($monthlyAvg, 1),
                    'best_month' => $bestMonth
                ],
                'chartData' => [
                    'labels' => array_column($monthlyStats, 'month'),
                    'income_data' => array_column($monthlyStats, 'income')
                ]
            ];
        }
    }

    public function reportsExport(Request $request, $type)
    {
        $date = $request->input('date');
        $month = $request->input('month');
        $year = $request->input('year');

        // Get reservations based on report type
        $reservasiQuery = Reservasi::with(['user', 'lapangan']);

        switch ($type) {
            case 'daily':
                $reservasiQuery->whereDate('tanggal_reservasi_232112', $date);
                $title = 'Laporan Harian';
                $periode = \Carbon\Carbon::parse($date)->format('d F Y');
                break;
            case 'monthly':
                $dateObj = \Carbon\Carbon::parse($month . '-01');
                $reservasiQuery->whereYear('tanggal_reservasi_232112', $dateObj->year)
                               ->whereMonth('tanggal_reservasi_232112', $dateObj->month);
                $title = 'Laporan Bulanan';
                $periode = $dateObj->format('F Y');
                break;
            case 'yearly':
                $reservasiQuery->whereYear('tanggal_reservasi_232112', $year);
                $title = 'Laporan Tahunan';
                $periode = $year;
                break;
            default:
                return redirect()->back()->with('error', 'Invalid report type');
        }

        $reservasi = $reservasiQuery->orderByDesc('created_at_232112')->get();

        // Calculate total income for the period
        $totalPendapatan = $reservasi->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->sum('total_harga_232112');

        // Create export
        $export = new class($reservasi, $totalPendapatan, $title, $periode) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle
        {
            private $reservasi;
            private $totalPendapatan;
            private $title;
            private $periode;

            public function __construct($reservasi, $totalPendapatan, $title, $periode)
            {
                $this->reservasi = $reservasi;
                $this->totalPendapatan = $totalPendapatan;
                $this->title = $title . ' (' . $periode . ')';
                $this->periode = $periode;
            }

            public function headings(): array
            {
                return [
                    'ID Reservasi',
                    'Nama User',
                    'Email User',
                    'Nama Lapangan',
                    'Jenis Lapangan',
                    'Tanggal Reservasi',
                    'Waktu Mulai',
                    'Waktu Selesai',
                    'Total Harga',
                    'Status Reservasi',
                    'Catatan',
                    'Tanggal Dibuat'
                ];
            }

            public function title(): string
            {
                return $this->title;
            }

            public function collection()
            {
                return collect($this->reservasi)->map(function ($item) {
                    return [
                        $item->reservasi_id_232112,
                        $item->user->nama_232112,
                        $item->user->email_232112,
                        $item->lapangan->nama_lapangan_232112,
                        $item->lapangan->jenis_lapangan_232112,
                        $item->tanggal_reservasi_232112,
                        $item->waktu_mulai_232112,
                        $item->waktu_selesai_232112,
                        $item->total_harga_232112,
                        $item->status_reservasi_232112,
                        $item->catatan_232112,
                        $item->created_at_232112,
                    ];
                });
            }
        };

        return Excel::download($export, $title . '_' . $periode . '_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function reportsExportPdf(Request $request, $type)
    {
        $date = $request->input('date');
        $month = $request->input('month');
        $year = $request->input('year');

        // Get reservations based on report type
        $reservasiQuery = Reservasi::with(['user', 'lapangan']);

        switch ($type) {
            case 'daily':
                $reservasiQuery->whereDate('tanggal_reservasi_232112', $date);
                $title = 'Laporan Harian';
                $periode = \Carbon\Carbon::parse($date)->format('d F Y');
                break;
            case 'monthly':
                $dateObj = \Carbon\Carbon::parse($month . '-01');
                $reservasiQuery->whereYear('tanggal_reservasi_232112', $dateObj->year)
                               ->whereMonth('tanggal_reservasi_232112', $dateObj->month);
                $title = 'Laporan Bulanan';
                $periode = $dateObj->format('F Y');
                break;
            case 'yearly':
                $reservasiQuery->whereYear('tanggal_reservasi_232112', $year);
                $title = 'Laporan Tahunan';
                $periode = $year;
                break;
            default:
                return redirect()->back()->with('error', 'Invalid report type');
        }

        $reservasi = $reservasiQuery->orderByDesc('created_at_232112')->get();

        // Calculate total income for the period
        $totalPendapatan = $reservasi->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->sum('total_harga_232112');

        // Generate PDF
        $pdf = \PDF::loadView('admin.report.pdf', [
            'reservasi' => $reservasi,
            'totalPendapatan' => $totalPendapatan,
            'periodeInfo' => $title . ' (' . $periode . ')'
        ])->setPaper('a4', 'landscape');

        return $pdf->download($title . '_' . $periode . '_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    // New method to get detailed report data for table display
    public function detailedReportData(Request $request)
    {
        $reportType = $request->input('type');
        $date = $request->input('date');
        $month = $request->input('month');
        $year = $request->input('year');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Base query for reservations with necessary relationships
        $reservasiQuery = Reservasi::with(['user', 'lapangan']);

        // Apply filters based on report type and available date filters
        if ($startDate && $endDate) {
            // If both start and end date are provided, use date range regardless of report type
            $reservasiQuery->whereBetween('tanggal_reservasi_232112', [$startDate, $endDate]);
        } else {
            // Apply filters based on report type
            switch ($reportType) {
                case 'daily':
                    if ($date) {
                        $reservasiQuery->whereDate('tanggal_reservasi_232112', $date);
                    } else {
                        $reservasiQuery->whereDate('tanggal_reservasi_232112', today());
                    }
                    break;
                case 'monthly':
                    if ($month) {
                        $dateObj = \Carbon\Carbon::parse($month . '-01');
                        $reservasiQuery->whereYear('tanggal_reservasi_232112', $dateObj->year)
                                       ->whereMonth('tanggal_reservasi_232112', $dateObj->month);
                    } else {
                        $reservasiQuery->whereYear('tanggal_reservasi_232112', now()->year)
                                       ->whereMonth('tanggal_reservasi_232112', now()->month);
                    }
                    break;
                case 'yearly':
                    if ($year) {
                        $reservasiQuery->whereYear('tanggal_reservasi_232112', $year);
                    } else {
                        $reservasiQuery->whereYear('tanggal_reservasi_232112', now()->year);
                    }
                    break;
                default:
                    return response()->json(['success' => false, 'message' => 'Invalid report type']);
            }
        }

        $reservasi = $reservasiQuery->orderBy('tanggal_reservasi_232112', 'desc')
                                    ->orderBy('waktu_mulai_232112', 'asc')
                                    ->get();

        // Format the data for the table
        $tableData = $reservasi->map(function ($item) {
            return [
                'id' => $item->reservasi_id_232112,
                'user_name' => $item->user->nama_232112,
                'user_email' => $item->user->email_232112,
                'lapangan_name' => $item->lapangan->nama_lapangan_232112,
                'lapangan_jenis' => $item->lapangan->jenis_lapangan_232112,
                'tanggal_reservasi' => \Carbon\Carbon::parse($item->tanggal_reservasi_232112)->format('d M Y'),
                'waktu_mulai' => $item->waktu_mulai_232112,
                'waktu_selesai' => $item->waktu_selesai_232112,
                'total_harga' => $item->total_harga_232112,
                'status' => $item->status_reservasi_232112,
                'formatted_harga' => 'Rp ' . number_format($item->total_harga_232112, 0, ',', '.')
            ];
        });

        // Calculate total income for the period
        $totalPendapatan = $reservasi->whereIn('status_reservasi_232112', ['confirmed', 'completed'])
            ->sum('total_harga_232112');

        return response()->json([
            'success' => true,
            'data' => $tableData,
            'total_pendapatan' => $totalPendapatan,
            'formatted_total_pendapatan' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.')
        ]);
    }
}
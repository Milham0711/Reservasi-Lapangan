<?php

namespace App\Exports;

use App\Models\Reservasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReservasiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Reservasi::with(['user', 'lapangan'])->orderByDesc('created_at_232112')->get();
    }

    public function headings(): array
    {
        return [
            'ID Reservasi',
            'Nama Pemesan',
            'Email Pemesan',
            'Nama Lapangan',
            'Jenis Lapangan',
            'Tanggal',
            'Waktu Mulai',
            'Waktu Selesai',
            'Total Harga',
            'Status',
            'Tanggal Dibuat',
        ];
    }

    public function map($reservasi): array
    {
        return [
            $reservasi->reservasi_id_232112,
            $reservasi->user->nama_232112,
            $reservasi->user->email_232112,
            $reservasi->lapangan->nama_lapangan_232112,
            $reservasi->lapangan->jenis_lapangan_232112,
            \Carbon\Carbon::parse($reservasi->tanggal_reservasi_232112)->format('d/m/Y'),
            $reservasi->waktu_mulai_232112,
            $reservasi->waktu_selesai_232112,
            $reservasi->total_harga_232112,
            $reservasi->status_reservasi_232112,
            \Carbon\Carbon::parse($reservasi->created_at_232112)->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0'],
                ],
            ],
        ];
    }
}
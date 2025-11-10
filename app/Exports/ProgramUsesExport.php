<?php

namespace App\Exports;

use App\Models\ProgramUse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProgramUsesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return ProgramUse::with('program')->orderBy('tanggal', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Program',
            'Keterangan',
            'Lokasi',
            'Jumlah',
            'Tanggal Transaksi',
        ];
    }

    public function map($use): array
    {
        return [
            $use->program->title ?? '-',
            $use->note ?? '-',
            $use->program->location ?? '-',
            number_format($use->amount, 0, ',', '.'),
            $use->tanggal ? $use->tanggal->format('d/m/Y') : '-',
        ];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramUse;
use App\Models\Program;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProgramUsesExport;

class ProgramUseExportController extends Controller
{
public function exportPdf()
{
    $programUses = ProgramUse::with('program')
        ->whereMonth('tanggal', now()->month)
        ->whereYear('tanggal', now()->year)
        ->orderBy('tanggal', 'desc')
        ->get();

    $pdf = Pdf::loadView('admin.programs.pdf', compact('programUses'))
        ->setPaper('a4', 'landscape');

    return $pdf->stream('Laporan_Pengeluaran_Dana_' . now()->format('F_Y') . '.pdf');
}


    public function exportExcel()
    {
        return Excel::download(new ProgramUsesExport, 'Laporan_Penyaluran_Donasi.xlsx');
    }

}

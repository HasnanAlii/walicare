<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramUse;
use Illuminate\Http\Request;

class ProgramUseController extends Controller
{
    /**
     * Tampilkan daftar semua penggunaan dana.
     */
    public function index()
    {
        $uses = ProgramUse::with('program')
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.programs.indexx', compact('uses'));
    }

    /**
     * Simpan penggunaan dana baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'amount'     => ['required', 'numeric', 'min:0'],
            'tanggal'    => ['nullable', 'date'],
            'note'       => ['nullable', 'string', 'max:1000'],
        ]);

        $program = Program::findOrFail($validated['program_id']);

        ProgramUse::create($validated);

        return redirect()
            ->route('admin.programs.show', $program)
            ->with([
                'message' => 'Penggunaan dana berhasil ditambahkan!',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Hapus satu data penggunaan dana.
     */
    public function destroy(ProgramUse $program_us)
    {
            $program_us->delete();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Penggunaan dana berhasil dihapus!',
                    'alert-type' => 'success'
                ]);
    
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use App\Models\Beneficiary;
use App\Models\Program;
use Illuminate\Support\Facades\Storage;

class BeneficiaryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['role_or_permission:Superadmin|Program Manager|manage programs']);
    // }

    /**
     * Tampilkan daftar penerima bantuan.
     */
    public function index()
    {
        $beneficiaries = Beneficiary::with('program')->latest()->paginate(20);
        return view('admin.beneficiaries.index', compact('beneficiaries'));
    }

    /**
     * Form tambah penerima baru.
     */
    public function create()
    {
        $programs = Program::pluck('title', 'id');
        return view('admin.beneficiaries.create', compact('programs'));
    }

    /**
     * Simpan penerima baru.
     */
    public function store(StoreBeneficiaryRequest $request)
    {
        $data = $request->validated();

        // simpan foto jika ada
        if ($request->hasFile('photo_path')) {
            $data['photo_path'] = $request->file('photo_path')->store('beneficiaries', 'public');
        }

        Beneficiary::create($data);

        return redirect()
            ->route('admin.beneficiaries.index')
            ->with('success', 'Penerima bantuan berhasil ditambahkan.');
    }

    /**
     * Form edit penerima bantuan.
     */
    public function edit(Beneficiary $beneficiary)
    {
        $programs = Program::pluck('title', 'id');
        return view('admin.beneficiaries.edit', compact('beneficiary', 'programs'));
    }

    /**
     * Update penerima bantuan.
     */
    public function update(UpdateBeneficiaryRequest $request, Beneficiary $beneficiary)
    {
        $data = $request->validated();

        if ($request->hasFile('photo_path')) {
            // hapus foto lama jika ada
            if ($beneficiary->photo_path && Storage::disk('public')->exists($beneficiary->photo_path)) {
                Storage::disk('public')->delete($beneficiary->photo_path);
            }

            $data['photo_path'] = $request->file('photo_path')->store('beneficiaries', 'public');
        }

        $beneficiary->update($data);

        return redirect()
            ->route('admin.beneficiaries.index')
            ->with('success', 'Data penerima bantuan berhasil diperbarui.');
    }

    /**
     * Hapus penerima bantuan.
     */
    public function destroy(Beneficiary $beneficiary)
    {
        if ($beneficiary->photo_path && Storage::disk('public')->exists($beneficiary->photo_path)) {
            Storage::disk('public')->delete($beneficiary->photo_path);
        }

        $beneficiary->delete();

        return back()->with('success', 'Data penerima bantuan berhasil dihapus.');
    }
}

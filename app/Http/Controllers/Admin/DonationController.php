<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\UpdateDonationRequest;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    // public function __construct()
    // {
    //     // Pastikan login dan memiliki role/permission
    //     $this->middleware(['auth', 'role_or_permission:Superadmin|Finance|verify donations']);
    // }

    /**
     * Menampilkan semua data donasi
     */
    public function index()
    {
        $donations = Donation::with(['program', 'user'])->latest()->paginate(20);
        return view('admin.donations.index', compact('donations'));
    }

    /**
     * Form tambah donasi manual
     */
    public function create()
    {
        return view('admin.donations.create');
    }

    /**
     * Simpan donasi baru (jika dibuat manual oleh admin)
     */
    public function store(StoreDonationRequest $request)
    {
        $data = $request->validated();

        $data['status'] = 'confirmed';
        Donation::create($data);

        return redirect()
            ->route('admin.donations.index')
            ->with('success', 'Donasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail donasi
     */
    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }

    /**
     * Update status / data donasi
     */
    public function update(UpdateDonationRequest $request, Donation $donation)
    {
        $data = $request->validated();

        // upload file bukti transfer jika ada
        if ($request->hasFile('proof_path')) {
            $path = $request->file('proof_path')->store('donations', 'public');
            $data['proof_path'] = $path;
        }

        $donation->update($data);

        return redirect()
            ->route('admin.donations.index')
            ->with('success', 'Data donasi berhasil diperbarui.');
    }

    /**
     * Hapus donasi
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();
        return back()->with('success', 'Data donasi berhasil dihapus.');
    }
}

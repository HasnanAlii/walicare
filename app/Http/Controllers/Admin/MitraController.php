<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{
    /**
     * Tampilkan daftar mitra.
     */
    public function index()
    {
        $mitras = Mitra::latest()->paginate(10);
        return view('admin.mitras.index', compact('mitras'));
    }

    /**
     * Tampilkan semua mitra di halaman publik.
     */
    public function showAll()
    {
        $mitras = Mitra::latest()->get();
        return view('front.tentangkami.mitra', compact('mitras'));
    }

    /**
     * Form tambah mitra.
     */
    public function create()
    {
        return view('admin.mitras.create');
    }

    /**
     * Simpan data mitra baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $data = $request->only(['name', 'url', 'description']);

            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('mitras', 'public');
            }

            Mitra::create($data);

            return redirect()
                ->route('admin.mitras.index')
                ->with([
                    'message' => 'Mitra berhasil ditambahkan!',
                    'alert-type' => 'success'
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.mitras.index')
                ->with([
                    'message' => 'Terjadi kesalahan saat menambahkan mitra!',
                    'alert-type' => 'error'
                ]);
        }
    }

    /**
     * Form edit mitra.
     */
    public function edit(Mitra $mitra)
    {
        return view('admin.mitras.edit', compact('mitra'));
    }

    /**
     * Update data mitra.
     */
    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $data = $request->only(['name', 'url', 'description']);

            // Hapus logo lama jika upload baru
            if ($request->hasFile('logo')) {
                if ($mitra->logo && Storage::disk('public')->exists($mitra->logo)) {
                    Storage::disk('public')->delete($mitra->logo);
                }

                $data['logo'] = $request->file('logo')->store('mitras', 'public');
            }

            $mitra->update($data);

            return redirect()
                ->route('admin.mitras.index')
                ->with([
                    'message' => 'Mitra berhasil diperbarui!',
                    'alert-type' => 'success'
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.mitras.index')
                ->with([
                    'message' => 'Terjadi kesalahan saat memperbarui mitra!',
                    'alert-type' => 'error'
                ]);
        }
    }

    /**
     * Hapus mitra.
     */
    public function destroy(Mitra $mitra)
    {
        try {
            if ($mitra->logo && Storage::disk('public')->exists($mitra->logo)) {
                Storage::disk('public')->delete($mitra->logo);
            }

            $mitra->delete();

            return redirect()
                ->route('admin.mitras.index')
                ->with([
                    'message' => 'Mitra berhasil dihapus!',
                    'alert-type' => 'success'
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.mitras.index')
                ->with([
                    'message' => 'Terjadi kesalahan saat menghapus mitra!',
                    'alert-type' => 'error'
                ]);
        }
    }
}

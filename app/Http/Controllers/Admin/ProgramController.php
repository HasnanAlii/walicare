<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use Illuminate\Http\Request;   
use App\Models\ProgramCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    /**
     * Tampilkan semua program beserta kategorinya.
     */
    public function index()
    {
        $programs = Program::with('category')->latest()->paginate(15);
        return view('admin.programs.index', compact('programs'));
    }

    /**
     * Tampilkan form untuk membuat program baru.
     */
    public function create()
    {
        $categories = ProgramCategory::pluck('name', 'id');
        return view('admin.programs.create', compact('categories'));
    }

    /**
     * Simpan data program baru.
     */
    public function store(Request $request)
    {
        // Validasi manual
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:program_categories,id'],
            'title' => ['required', 'string', 'max:255', 'unique:programs,title'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:programs,slug'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'target_amount' => ['required'],
            'collected_amount' => ['nullable'],
            'breakdown' => ['nullable', 'array'],
            'status' => ['required', 'in:draft,active,completed,cancelled'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:15120'], 
        ]);

        // Bersihkan angka dari titik (misalnya "10.000" → "10000")
        $validated['target_amount'] = str_replace('.', '', $validated['target_amount']);
        $validated['collected_amount'] = str_replace('.', '', $validated['collected_amount'] ?? 0);

        // Tambahkan ID pembuat
        $validated['created_by'] = Auth::id();

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        // Slug otomatis
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Simpan data program
        Program::create($validated);

        return redirect()
            ->route('admin.programs.index')
            ->with([
                'message' => 'Program berhasil dibuat!',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Form edit program.
     */
    public function edit(Program $program)
    {
        $categories = ProgramCategory::pluck('name', 'id');
        return view('admin.programs.edit', compact('program', 'categories'));
    }

    /**
     * Perbarui data program.
     */
public function update(Request $request, Program $program)
{
    // 🔍 Validasi input
    $validated = $request->validate([
        'category_id' => ['nullable', 'exists:program_categories,id'],
        'title' => ['required', 'string', 'max:255', 'unique:programs,title,' . $program->id],
        'slug' => ['nullable', 'string', 'max:255', 'unique:programs,slug,' . $program->id],
        'summary' => ['nullable', 'string', 'max:500'],
        'description' => ['nullable', 'string'],
        'target_amount' => ['required'],
        'collected_amount' => ['nullable'],
        'status' => ['required', 'in:draft,active,completed,cancelled'],
        'start_date' => ['nullable', 'date'],
        'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        'location' => ['nullable', 'string', 'max:255'],
        'is_featured' => ['nullable', 'boolean'],
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:15120'],
    ]);

    // 🔢 Bersihkan angka dari format ribuan (contoh: "10.000" → "10000")
    $validated['target_amount'] = (int) str_replace('.', '', $validated['target_amount']);
    $validated['collected_amount'] = (int) str_replace('.', '', $validated['collected_amount'] ?? 0);

   

    // 🖼️ Upload gambar baru (hapus lama jika ada)
    if ($request->hasFile('image')) {
        if ($program->image && Storage::disk('public')->exists($program->image)) {
            Storage::disk('public')->delete($program->image);
        }
        $validated['image'] = $request->file('image')->store('programs', 'public');
    }

    // 🧩 Buat slug otomatis jika kosong
    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['title']);
    }

    // 💾 Simpan perubahan ke database
    $program->update($validated);

    return redirect()
        ->route('admin.programs.index')
        ->with([
            'message' => 'Program berhasil diperbarui!',
            'alert-type' => 'success'
        ]);

    }

    /**
     * Hapus program.
     */
    public function destroy(Program $program)
    {
        try {
            // Hapus file gambar jika ada
            if ($program->image && Storage::disk('public')->exists($program->image)) {
                Storage::disk('public')->delete($program->image);
            }

            $program->delete();

            return redirect()
                ->route('admin.programs.index')
                ->with([
                    'message' => 'Program berhasil dihapus!',
                    'alert-type' => 'success'
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.programs.index')
                ->with([
                    'message' => 'Terjadi kesalahan saat menghapus program.',
                    'alert-type' => 'error'
                ]);
        }
    }

    /**
     * Tampilkan detail program.
     */
    public function show(Program $program)
    {
        // Load semua relasi yang dibutuhkan
        $program->load(['category', 'media', 'uses']);

        // Decode breakdown JSON
        $breakdown = $program->breakdown ? json_decode($program->breakdown, true) : [];

        // Ambil media dan donasi terbaru
        $media = $program->media;
        $recentDonations = $program->donations()
            ->where('status', 'confirmed')
            ->latest()
            ->take(15)
            ->get();

        return view('admin.programs.show', compact(
            'program',
            'recentDonations',
            'breakdown',
            'media'
        ));
    }


}

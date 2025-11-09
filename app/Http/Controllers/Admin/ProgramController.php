<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use App\Models\ProgramCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    // public function __construct()
    // {
    //     // Pastikan user memiliki salah satu role atau permission berikut
    //     $this->middleware(['role_or_permission:Superadmin|Program Manager|manage programs']);
    // }

    /**
     * Tampilkan semua program beserta kategorinya.
     */
    public function index()
    {
        $programs = Program::with('category')
            ->latest()
            ->paginate(15);

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
  public function store(StoreProgramRequest $request)
{
    $data = $request->validated();
    $data['created_by'] = Auth::id();

    // Handle upload image
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('programs', 'public'); 
        // Akan tersimpan di storage/app/public/programs
    }

    // Jika slug kosong, generate otomatis dari title
    if (empty($data['slug'])) {
        $data['slug'] = Str::slug($data['title']);
    }

    Program::create($data);

    return redirect()
        ->route('admin.programs.index')
        ->with('success', 'Program berhasil dibuat.');
}

public function update(UpdateProgramRequest $request, Program $program)
{
    $data = $request->validated();

    // Handle upload image baru
    if ($request->hasFile('image')) {
        // Hapus file lama jika ada
        if ($program->image && Storage::disk('public')->exists($program->image)) {
            Storage::disk('public')->delete($program->image);
        }

        $data['image'] = $request->file('image')->store('programs', 'public');
    }

    // Regenerate slug jika kosong
    if (empty($data['slug'])) {
        $data['slug'] = Str::slug($data['title']);
    }

    $program->update($data);

    return redirect()
        ->route('admin.programs.index')
        ->with('success', 'Program berhasil diperbarui.');
}


    /**
     * Tampilkan form edit program.
     */
    public function edit(Program $program)
    {
        $categories = ProgramCategory::pluck('name', 'id');
        return view('admin.programs.edit', compact('program', 'categories'));
    }

    /**
     * Perbarui data program.
     */
    // public function update(UpdateProgramRequest $request, Program $program)
    // {
    //     $data = $request->validated();

    //     // regenerate slug jika judul berubah dan slug kosong
    //     if (empty($data['slug'])) {
    //         $data['slug'] = Str::slug($data['title']);
    //     }

    //     $program->update($data);

    //     return redirect()
    //         ->route('admin.programs.index')
    //         ->with('success', 'Program berhasil diperbarui.');
    // }

    /**
     * Hapus program.
     */
public function destroy(Program $program)
{
    $program->delete();

    return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
}

 public function show(Program $program)
{
    $program->load(['category', 'media']);

    $breakdown = $program->breakdown ? json_decode($program->breakdown, true) : [];

    $media = $program->media;
    $recentDonations = $program->donations()
    ->where('status', 'confirmed')
    ->latest()
    ->take(15)
    ->get();


    return view('admin.programs.show', compact('program', 'recentDonations','breakdown', 'media'));
}


}

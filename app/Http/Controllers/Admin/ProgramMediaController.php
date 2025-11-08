<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramMediaRequest;
use App\Models\Program;
use App\Models\ProgramMedia;
use Illuminate\Support\Facades\Storage;

class ProgramMediaController extends Controller
{
        public function index(Program $program)
    {
        $media = $program->media()->orderBy('order')->get();
        return view('admin.program_media.index', compact('program', 'media'));
    }

    public function create(Program $program)
    {
        return view('admin.program_media.create', compact('program'));
    }

    public function store(StoreProgramMediaRequest $request)
    {
        $program = Program::findOrFail($request->program_id);

        $lastOrder = $program->media()->max('order') ?? 0;

       $path = $request->hasFile('path') 
    ? $request->file('path')->store('program_media', 'public') 
    : null;

        $program->media()->create([
            'type'    => $request->type,
            'path'    => $path,
            'caption' => $request->caption,
            'order'   => $lastOrder + 1,
        ]);

        return redirect()->route('admin.programs.show', $program)
                        ->with('success', 'Media berhasil ditambahkan.');
    }

public function destroy(ProgramMedia $media)
{
    $program = $media->program; // Ambil program terkait

    // Hapus file jika ada
    if ($media->path && Storage::exists($media->path)) {
        Storage::delete($media->path);
    }

    // Hapus record media
    $media->delete();

    // Redirect ke halaman show program
    return redirect()->route('admin.programs.show', ['program' => $program->id])
                     ->with('success', 'Media berhasil dihapus.');
}

public function edit(ProgramMedia $media)
{
    $program = $media->program; // Ambil program terkait
    return view('admin.program_media.edit', compact('program', 'media'));
}




}

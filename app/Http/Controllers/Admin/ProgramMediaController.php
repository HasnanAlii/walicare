<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramMediaRequest;
use App\Models\Program;
use App\Models\ProgramMedia;
use Illuminate\Support\Facades\Storage;

class ProgramMediaController extends Controller
{
    /**
     * Tampilkan semua media untuk program tertentu.
     */
    public function index(Program $program)
    {
        $media = $program->media()->orderBy('order')->get();
        return view('admin.program_media.index', compact('program', 'media'));
    }

    /**
     * Form tambah media ke program.
     */
    public function create(Program $program)
    {
        return view('admin.program_media.create', compact('program'));
    }

    /**
     * Simpan media baru untuk program.
     */
    public function store(StoreProgramMediaRequest $request)
    {
        try {
            $program = Program::findOrFail($request->program_id);

            $lastOrder = $program->media()->max('order') ?? 0;

            // Simpan file jika ada
            $path = $request->hasFile('path') 
                ? $request->file('path')->store('program_media', 'public') 
                : null;

            $program->media()->create([
                'type'    => $request->type,
                'path'    => $path,
                'caption' => $request->caption,
                'order'   => $lastOrder + 1,
            ]);

            return redirect()
                ->route('admin.programs.show', $program)
                ->with([
                    'message' => 'Media berhasil ditambahkan!',
                    'alert-type' => 'success'
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with([
                    'message' => 'Terjadi kesalahan saat menambahkan media!',
                    'alert-type' => 'error'
                ]);
        }
    }

    /**
     * Form edit media program.
     */
    public function edit(ProgramMedia $media)
    {
        $program = $media->program;
        return view('admin.program_media.edit', compact('program', 'media'));
    }

    /**
     * Hapus media dari program.
     */
  public function destroy(ProgramMedia $media)
    {
            $program = $media->program;

            if ($media->path && Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }

            $media->delete();

            return redirect()
                   ->back()
                ->with([
                    'message' => 'Kabar atau media berhasil dihapus!',
                    'alert-type' => 'success'
                ]);
       
    }
}

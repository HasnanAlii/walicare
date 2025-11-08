<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMilestoneRequest;
use App\Models\Milestone;
use App\Models\Program;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    /**
     * Tampilkan daftar milestone.
     */
    public function index()
    {
        $milestones = Milestone::with('program')
            ->latest()
            ->paginate(10);

        return view('admin.milestones.index', compact('milestones'));
    }

    /**
     * Tampilkan form untuk membuat milestone baru.
     */
    public function create()
    {
        $programs = Program::pluck('title', 'id');
        return view('admin.milestones.create', compact('programs'));
    }

    /**
     * Simpan milestone baru ke database.
     */
    public function store(StoreMilestoneRequest $request)
    {
        Milestone::create($request->validated());

        return redirect()
            ->route('admin.milestones.index')
            ->with('success', 'Milestone baru berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail milestone tertentu.
     */
    public function show(Milestone $milestone)
    {
        $milestone->load('program');
        return view('admin.milestones.show', compact('milestone'));
    }

    /**
     * Tampilkan form edit milestone.
     */
    public function edit(Milestone $milestone)
    {
        $programs = Program::pluck('title', 'id');
        return view('admin.milestones.edit', compact('milestone', 'programs'));
    }

    /**
     * Perbarui data milestone di database.
     */
    public function update(StoreMilestoneRequest $request, Milestone $milestone)
    {
        $milestone->update($request->validated());

        return redirect()
            ->route('admin.milestones.index')
            ->with('success', 'Milestone berhasil diperbarui!');
    }

    /**
     * Hapus milestone dari database.
     */
    public function destroy(Milestone $milestone)
    {
        $milestone->delete();

        return redirect()
            ->route('admin.milestones.index')
            ->with('success', 'Milestone berhasil dihapus!');
    }
}

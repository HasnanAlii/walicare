<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Donation;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Tampilkan daftar program donasi aktif di halaman depan.
     */
    public function index(Request $request)
    {
        // Filter berdasarkan kategori jika ada
        $query = Program::with('category')
            ->where('status', 'active');

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $programs = $query->latest()->paginate(9);
        $categories = ProgramCategory::orderBy('name')->get();

        return view('front.programs.index', compact('programs', 'categories'));
    }

    /**
     * Tampilkan detail dari satu program.
     */
   public function show(string $slug)
    {
        // Muat semua relasi yang dibutuhkan: kategori, media, dan donasi yang terkonfirmasi
        $program = Program::with([
            'category', 
            'media', // Tambahkan ini
            'donations' => function ($q) {
                $q->where('status', 'confirmed');
            }
        ])->where('slug', $slug)->firstOrFail();

        // Hitung total donasi dan persentase progress
        $totalDonations = $program->donations->sum('amount');
        $target = $program->target_amount ?: 1; // hindari pembagian 0
        $progress = round(($totalDonations / $target) * 100, 2);

        // Ambil donasi terbaru (confirmed) untuk ditampilkan di tab "Donatur"
        $recentDonations = $program->donations()
            ->where('status', 'confirmed') // Pastikan hanya donasi terkonfirmasi
            ->latest()
            ->take(15) // Ambil lebih banyak untuk tab donatur
            ->get();
            
        // Decode breakdown JSON, sama seperti di admin
        $breakdown = $program->breakdown ? json_decode($program->breakdown, true) : [];

        return view('front.programs.show', compact(
            'program',
            'totalDonations',
            'progress',
            'recentDonations',
            'breakdown' // Tambahkan ini
        ));
    }
}

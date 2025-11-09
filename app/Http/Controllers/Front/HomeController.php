<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Donation;
use App\Models\ProgramCategory;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (landing page).
     */
    public function index()
    {
        $featuredPrograms = Program::where('is_featured', true)
            ->where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        $latestPrograms = Program::where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        $totalDonation = Donation::where('status', 'confirmed')->sum('amount');
        $totalDonors = Donation::where('status', 'confirmed')->distinct('donor_email')->count();
        $totalPrograms = Program::count();

        $categories = ProgramCategory::orderBy('name')->get();

        return view('front.home', compact(
            'featuredPrograms',
            'latestPrograms',
            'totalDonation',
            'totalDonors',
            'totalPrograms',
            'categories'
        ));
    }

    /**
     * Halaman Sejarah.
     */
    public function sejarah()
    {
        return view('front.tentangkami.sejarah');
    }

    /**
     * Halaman Tentang Kami.
     */
    public function tentangKami()
    {
        return view('front.tentangkami.tentangkami');
    }

    /**
     * Halaman Kontak Kami.
     */
    public function kontak()
    {
        return view('front.tentangkami.kontak');
    }
}

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
        // Ambil program unggulan
        $featuredPrograms = Program::where('is_featured', true)
            ->where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        // Ambil beberapa program terbaru
        $latestPrograms = Program::where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        // Hitung total statistik donasi
        $totalDonation = Donation::where('status', 'confirmed')->sum('amount');
        $totalDonors = Donation::where('status', 'confirmed')->distinct('donor_email')->count();
        $totalPrograms = Program::count();

        // Ambil kategori program untuk filter di front page
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
}

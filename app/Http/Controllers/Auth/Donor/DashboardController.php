<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;

class DashboardController extends Controller
{
    public function donations()
    {
        // pastikan route dilindungi auth, jika tidak, kita cek
        $userId = Auth::id();
        if (! $userId) {
            // jika belum login, redirect ke login atau tampilkan pesan
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melihat riwayat donasi.');
        }

        // ambil donasi berdasarkan kolom user_id (eager load program)
        $donations = Donation::where('user_id', $userId)
            ->with('program')    // pastikan relasi program ada di model Donation
            ->latest()
            ->paginate(10);

        return view('donor.dashboard.donations', compact('donations'));
    }
}

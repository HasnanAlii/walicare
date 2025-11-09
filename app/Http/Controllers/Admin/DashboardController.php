<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Program;
use App\Models\Donation;
use App\Models\User;
use App\Models\Mitra;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // === UNTUK SUPERADMIN ===
        if (Auth::user()->hasRole('Superadmin')) {

            // 1. Total Donasi Berhasil
            $totalDonation = Donation::where('status', 'confirmed')->sum('amount');

            // 2. Program Aktif
            $activeProgramsCount = Program::where('end_date', '>=', Carbon::now())->count();

            // 3. Total Donasi Berdasarkan User ID (bukan email)
            // Menjumlahkan semua nominal donasi dari user yang telah konfirmasi
            $totalDonors = Donation::where('status', 'confirmed')
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count();

            // 4. Total Mitra
            $totalMitras = Mitra::count();

            // 5. Program Terbaru
            $recentPrograms = Program::latest()->take(4)->get();

            return view('admin.dashboard', compact(
                'totalDonation',
                'activeProgramsCount',
                'totalDonors',
                'totalMitras',
                'recentPrograms'
            ));
        }

             // === UNTUK DONATUR ===
            $user = Auth::user();

            // Total donasi user
            $totalDonationUser = Donation::where('user_id', $user->id)
                ->where('status', 'confirmed')
                ->sum('amount');

            // Jumlah transaksi
            $totalTransactions = Donation::where('user_id', $user->id)->count();

            // Jumlah program unik yang didukung
            $supportedPrograms = Donation::where('user_id', $user->id)
                ->distinct('program_id')
                ->count('program_id');

            
            // Riwayat donasi terakhir (5 terbaru)
            $recentDonations = Donation::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            return view('donor.dashboard', compact(
                'totalDonationUser',
                'totalTransactions',
                'supportedPrograms',
                'recentDonations'
            ));

    }
}

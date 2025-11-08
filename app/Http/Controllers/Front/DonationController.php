<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    /**
     * Simpan donasi baru dari form publik.
     */
    public function store(Request $request, Program $program)
    {
        // DISESUAIKAN: Validasi disamakan dengan skema dan StoreDonationRequest
        $data = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'amount' => 'required|numeric|min:10000',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'method' => 'required|in:bank_transfer,ewallet,va,manual', // DISESUAIKAN
            'note' => 'nullable|string', // DISESUAIKAN
        ]);

        // Jika user login, kaitkan dengan akunnya
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        // DIHAPUS: Logika 'is_anonymous' dihapus karena tidak ada di skema DB

        // Buat 'Unique Amount' untuk kemudahan verifikasi transfer
        // Contoh: Donasi 50.000 -> 50.123 (123 adalah 3 digit acak)
        $uniqueAmount = $data['amount'] + rand(100, 999);

        // Buat donasi
        // DISESUAIKAN: Field disamakan dengan skema DB
        $donation = Donation::create([
            'program_id' => $program->id,
            'user_id' => $data['user_id'] ?? null,
            'donor_name' => $data['donor_name'],
            'donor_email' => $data['donor_email'],
            'amount' => $uniqueAmount, // Simpan jumlah unik
            'method' => $data['method'], // DISESUAIKAN
            'note' => $data['note'] ?? null, // DISESUAIKAN
            'status' => 'pending', // Status awal
        ]);

        // TODO: Implementasikan logika Payment Gateway (Midtrans, dll) di sini jika ada.
        // Jika tidak, kita arahkan ke halaman konfirmasi manual.

        // Redirect ke halaman konfirmasi dengan membawa data donasi
        return redirect()->route('donations.confirmation', $donation->id);
    }

    /**
     * Tampilkan halaman konfirmasi setelah membuat donasi.
     */
    public function confirmation(Donation $donation)
    {
        // DISESUAIKAN: Key array disamakan dengan value 'method' yang baru
        $paymentDetails = [
            'bank_transfer' => [
                'bank' => 'Bank Transfer (BCA/Mandiri)',
                'name' => 'Yayasan Wali Care',
                'number' => '123-456-7890 (BCA) / 098-765-4321 (Mandiri)',
            ],
            'ewallet' => [
                'bank' => 'E-Wallet (GoPay/OVO)',
                'name' => 'Wali Care',
                'number' => '0812-3456-7890',
            ],
             'va' => [
                'bank' => 'Virtual Account',
                'name' => 'Selesaikan Pembayaran di Aplikasi Bank',
                'number' => '0812-3456-7890',
            ],
        ];

        // DISESUAIKAN: Menggunakan $donation->method
        $paymentInfo = $paymentDetails[$donation->method] ?? null;

        return view('front.donations.confirmation', compact('donation', 'paymentInfo'));
    }
}
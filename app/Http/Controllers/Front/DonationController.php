<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Services\MidtransConfig;
use Illuminate\Support\Facades\Http;

class DonationController extends Controller
{
 protected function updateDonationTransaction(Donation $donation, array $data)
{
    $status = $data['status'];
    $fraud  = $data['fraud_status'] ?? null;

    $updateData = [
        'transaction_id' => $data['transaction_id'] ?? $donation->transaction_id,
        'payment_type'   => $data['payment_type'] ?? $donation->payment_type,
        'bank'           => $data['bank'] ?? $donation->bank,
        'va_number'      => $data['va_number'] ?? $donation->va_number,
    ];

    if ($status === 'settlement' || ($status === 'capture' && $fraud === 'accept')) {
        $updateData['status'] = 'confirmed';
        $updateData['paid_at'] = now();
        $donation->program->increment('collected_amount', $donation->amount);
    } elseif ($status === 'pending') {
        $updateData['status'] = 'pending';
    } elseif (in_array($status, ['deny', 'cancel', 'expire'])) {
        $updateData['status'] = 'failed';
    }

    $donation->update($updateData);
}


    public function store(Request $request, Program $program)
    {
        $data = $request->validate([
            'program_id'   => 'required|exists:programs,id',
            'amount'       => 'required|numeric|min:10000',
            'donor_name'   => 'required|string|max:255',
            'donor_email'  => 'required|email|max:255',
            'method'       => 'required|in:bank_transfer,ewallet,va,manual',
            'note'         => 'nullable|string',
        ]);

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        $uniqueAmount = $data['amount'] + rand(10, 99);

        $donation = Donation::create([
            'program_id'   => $program->id,
            'user_id'      => $data['user_id'] ?? null,
            'donor_name'   => $data['donor_name'],
            'donor_email'  => $data['donor_email'],
            'amount'       => $uniqueAmount,
            'method'       => $data['method'],
            'note'         => $data['note'] ?? null,
            'status'       => 'pending',
        ]);

        MidtransConfig::init();

        $params = [
            'transaction_details' => [
                'order_id'     => 'DONASI-' . $donation->id,
                'gross_amount' => $uniqueAmount,
            ],
            'customer_details' => [
                'first_name' => $data['donor_name'],
                'email'      => $data['donor_email'],
            ],
            'item_details' => [[
                'id'       => $program->id,
                'price'    => $uniqueAmount,
                'quantity' => 1,
                'name'     => $program->title,
            ]],
            'callbacks' => [
                'finish'   => route('payment.success', ['donation' => $donation->id]),
                'unfinish' => route('payment.pending', ['donation' => $donation->id]),
                'error'    => route('payment.failed'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $donation->update(['snap_token' => $snapToken]);

        // Log::info('🧾 Midtrans Transaction Created', [
        //     'donation_id' => $donation->id,
        //     'snap_token'  => $snapToken,
        // ]);

        return view('front.donations.payment', compact('donation', 'snapToken'));
    }

    
public function midtransCallback(Request $request)
{
    MidtransConfig::init();
    $notif = new Notification();

    $orderId = $notif->order_id;
    $status = $notif->transaction_status;
    $fraud = $notif->fraud_status ?? null;
    $type = $notif->payment_type ?? null;

    $donationId = str_replace('DONASI-', '', $orderId);
    $donation = Donation::find($donationId);

    if (!$donation) {
        Log::warning('❌ Donation not found for callback', ['order_id' => $orderId]);
        return response()->json(['message' => 'Donation not found'], 404);
    }

    // Ambil data tambahan tergantung jenis pembayaran
    $bank = null;
    $va_number = null;

    if ($type === 'bank_transfer' && isset($notif->va_numbers[0])) {
        $bank = $notif->va_numbers[0]->bank ?? null;
        $va_number = $notif->va_numbers[0]->va_number ?? null;
    } elseif ($type === 'echannel') {
        $bank = 'mandiri';
        $va_number = $notif->bill_key ?? null;
    } elseif ($type === 'qris') {
        $bank = 'QRIS';
        $va_number = $notif->transaction_id ?? null;
    } elseif (in_array($type, ['gopay', 'shopeepay', 'other_ewallets'])) {
        $bank = strtoupper($type);
    }

    // Update donasi
    $this->updateDonationTransaction($donation, [
        'status'          => $status,
        'fraud_status'    => $fraud,
        'payment_type'    => $type,
        'transaction_id'  => $notif->transaction_id ?? $orderId,
        'bank'            => $bank,
        'va_number'       => $va_number,
    ]);

    return response()->json(['message' => 'Callback processed successfully']);
}





    
        public function success(Donation $donation)
        {
            if ($donation->status !== 'confirmed') {
            }

            return view('front.donations.success', compact('donation'));
        }

    
        public function pending(Donation $donation)
        {
            if ($donation->status === 'confirmed') {
                return redirect()->route('payment.success', $donation);
            }

            return view('front.donations.pending', compact('donation'));
        }

    
        public function failed()
        {
            return view('front.donations.failed');
        }

 
    public function testConnection()
    {
        MidtransConfig::init();

        $serverKey = env('MIDTRANS_SERVER_KEY');
        $url = env('MIDTRANS_IS_PRODUCTION')
            ? 'https://api.midtrans.com/v2/status/test-connection'
            : 'https://api.sandbox.midtrans.com/v2/status/test-connection';

        try {
            $response = Http::withBasicAuth($serverKey, '')->get($url);
            $body = $response->json();

            if ($response->ok() && isset($body['status_message'])) {
                return response()->json([
                    'success' => true,
                    'message' => '✅ Koneksi ke Midtrans berhasil!',
                    'environment' => env('MIDTRANS_IS_PRODUCTION') ? 'Production' : 'Sandbox',
                    'response' => $body,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => '❌ Gagal koneksi ke Midtrans.',
                'response' => $body,
            ], $response->status());
        } catch (\Exception $e) {
            // Log::error('❌ Midtrans Connection Error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan koneksi.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}

    // /**
    //  * Simpan donasi baru dari form publik.
    //  */
    // public function store(Request $request, Program $program)
    // {
    //     // DISESUAIKAN: Validasi disamakan dengan skema dan StoreDonationRequest
    //     $data = $request->validate([
    //         'program_id' => 'required|exists:programs,id',
    //         'amount' => 'required|numeric|min:10000',
    //         'donor_name' => 'required|string|max:255',
    //         'donor_email' => 'required|email|max:255',
    //         'method' => 'required|in:bank_transfer,ewallet,va,manual', // DISESUAIKAN
    //         'note' => 'nullable|string', // DISESUAIKAN
    //     ]);

    //     // Jika user login, kaitkan dengan akunnya
    //     if (Auth::check()) {
    //         $data['user_id'] = Auth::id();
    //     }

    //     // DIHAPUS: Logika 'is_anonymous' dihapus karena tidak ada di skema DB

    //     // Buat 'Unique Amount' untuk kemudahan verifikasi transfer
    //     // Contoh: Donasi 50.000 -> 50.123 (123 adalah 3 digit acak)
    //     $uniqueAmount = $data['amount'] + rand(100, 999);

    //     // Buat donasi
    //     // DISESUAIKAN: Field disamakan dengan skema DB
    //     $donation = Donation::create([
    //         'program_id' => $program->id,
    //         'user_id' => $data['user_id'] ?? null,
    //         'donor_name' => $data['donor_name'],
    //         'donor_email' => $data['donor_email'],
    //         'amount' => $uniqueAmount, // Simpan jumlah unik
    //         'method' => $data['method'], // DISESUAIKAN
    //         'note' => $data['note'] ?? null, // DISESUAIKAN
    //         'status' => 'confirmed', // Status awal
    //     ]);

    //     // TODO: Implementasikan logika Payment Gateway (Midtrans, dll) di sini jika ada.
    //     // Jika tidak, kita arahkan ke halaman konfirmasi manual.

    //     // Redirect ke halaman konfirmasi dengan membawa data donasi
    //     return redirect()->route('donations.confirmation', $donation->id);
    // }


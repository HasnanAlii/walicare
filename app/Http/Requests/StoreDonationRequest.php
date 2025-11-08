<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        return true; // ubah ke true agar bisa digunakan
    }

    /**
     * Aturan validasi untuk penyimpanan data.
     */
    public function rules(): array
    {
        return [
            'program_id' => 'nullable|exists:programs,id',
            'user_id' => 'nullable|exists:users,id',
            'donor_name' => 'required_without:user_id|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:1',
            'method' => 'required|in:bank_transfer,ewallet,va,manual',
            'status' => 'nullable|in:pending,confirmed,failed,refunded',
            'transaction_id' => 'nullable|string|max:255',
            'proof_path' => 'nullable|required_if:method,manual|file|mimes:jpg,jpeg,png,pdf|max:12048',
            'paid_at' => 'nullable|required_if:status,confirmed|date',
            'note' => 'nullable|string',
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'program_id.exists' => 'Program donasi tidak ditemukan.',
            'user_id.exists' => 'User tidak valid.',
            'donor_name.required_without' => 'Nama donor wajib diisi jika tidak login.',
            'amount.required' => 'Jumlah donasi wajib diisi.',
            'amount.numeric' => 'Jumlah donasi harus berupa angka.',
            'proof_path.mimes' => 'Bukti transfer harus berupa file JPG, JPEG, PNG, atau PDF.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'program_id' => 'nullable|exists:programs,id',
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'amount' => 'nullable|numeric|min:1',
            'method' => 'nullable|in:bank_transfer,ewallet,va,manual',
            'status' => 'nullable|in:pending,confirmed,failed,refunded',
            'transaction_id' => 'nullable|string|max:255',
            'proof_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'paid_at' => 'nullable|date',
            'note' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'proof_path.mimes' => 'Bukti transfer harus berupa file JPG, JPEG, PNG, atau PDF.',
            'amount.numeric' => 'Jumlah donasi harus berupa angka.',
        ];
    }
}

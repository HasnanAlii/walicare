<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMilestoneRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        return true; // izinkan untuk sementara
    }

    /**
     * Aturan validasi untuk penyimpanan milestone.
     */
    public function rules(): array
    {
        return [
            'program_id' => 'required|exists:programs,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'target_date' => 'nullable|date',
            'is_reached' => 'nullable|boolean',
        ];
    }

    /**
     * Pesan error kustom (opsional).
     */
    public function messages(): array
    {
        return [
            'program_id.required' => 'Program harus dipilih.',
            'program_id.exists' => 'Program tidak ditemukan.',
            'title.required' => 'Judul milestone wajib diisi.',
            'amount.required' => 'Jumlah target wajib diisi.',
            'amount.numeric' => 'Jumlah target harus berupa angka.',
        ];
    }
}

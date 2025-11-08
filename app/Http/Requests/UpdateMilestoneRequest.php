<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMilestoneRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk pembaruan milestone.
     */
    public function rules(): array
    {
        return [
            'program_id' => 'sometimes|exists:programs,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'sometimes|numeric|min:0',
            'target_date' => 'nullable|date',
            'is_reached' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'program_id.exists' => 'Program tidak ditemukan.',
            'title.string' => 'Judul milestone harus berupa teks.',
            'amount.numeric' => 'Jumlah target harus berupa angka.',
        ];
    }
}

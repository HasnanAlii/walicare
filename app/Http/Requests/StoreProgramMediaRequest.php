<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramMediaRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        return true; // izinkan semua user yang memiliki akses
    }

    /**
     * Aturan validasi untuk menyimpan media program baru.
     */
    public function rules(): array
    {
        return [
            // 'program_id' => 'required|exists:programs,id',
            'type' => 'required|in:image,video,text',
            'path' => $this->isMethod('post') ? 'nullable|file|max:5120' : 'nullable|file|max:5120',
            'caption' => 'nullable|string|max:255',
        ];
    }


    /**
     * Pesan kesalahan kustom.
     */
    public function messages(): array
    {
        return [
            'program_id.required' => 'Program wajib dipilih.',
            'program_id.exists' => 'Program tidak ditemukan.',
            'type.required' => 'Jenis media wajib diisi.',
            'type.in' => 'Jenis media harus salah satu dari: image, video, text.',
            'path.required' => 'Path media wajib diisi.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        // Izinkan semua user yang sudah terautentikasi
        return true;
    }

    /**
     * Aturan validasi untuk membuat kategori baru.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:program_categories,name'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:program_categories,slug'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Pesan error kustom (opsional, agar lebih informatif).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'slug.unique' => 'Slug sudah digunakan, silakan ubah.',
        ];
    }
}

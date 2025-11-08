<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeneficiaryRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk menambah data penerima manfaat.
     */
    public function rules(): array
    {
        return [
            'program_id' => ['required', 'exists:programs,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'photo_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'delivered' => ['boolean'],
            'delivered_at' => ['nullable', 'date'],
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'program_id.required' => 'Program wajib dipilih.',
            'program_id.exists' => 'Program yang dipilih tidak valid.',
            'name.required' => 'Nama penerima manfaat wajib diisi.',
            'photo_path.image' => 'File foto harus berupa gambar.',
            'photo_path.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk membuat program baru.
     */
    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:program_categories,id'],
            'title' => ['required', 'string', 'max:255', 'unique:programs,title'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:programs,slug'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'target_amount' => ['required', 'numeric', 'min:0'],
            'collected_amount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:draft,active,completed,cancelled'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:15120'], 
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul program wajib diisi.',
            'title.unique' => 'Judul program sudah digunakan.',
            'slug.unique' => 'Slug sudah digunakan.',
            'target_amount.required' => 'Target dana wajib diisi.',
            'target_amount.numeric' => 'Target dana harus berupa angka.',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 15MB.',
        ];
    }
}

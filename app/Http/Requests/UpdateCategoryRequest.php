<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk memperbarui kategori.
     */
    public function rules(): array
    {
        $categoryId = $this->route('category'); // ambil ID dari route parameter

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('program_categories', 'name')->ignore($categoryId),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('program_categories', 'slug')->ignore($categoryId),
            ],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Pesan error kustom (opsional).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'slug.unique' => 'Slug sudah digunakan.',
        ];
    }
}

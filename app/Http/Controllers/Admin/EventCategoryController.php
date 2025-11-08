<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventCategoryController extends Controller
{
    /**
     * Menampilkan semua kategori kegiatan (dengan paginasi)
     */
    public function index()
    {
        $categoriesevent = Category::latest()->paginate(10);
        return view('admin.categories.events.index', compact('categoriesevent'));
    }

    /**
     * Menampilkan form tambah kategori kegiatan
     */
    public function create()
    {
        return view('admin.categories.events.create');
    }

    /**
     * Simpan kategori kegiatan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $count = Category::where('slug', 'like', "$slug%")->count();
        $slug = $count ? "{$slug}-" . ($count + 1) : $slug;

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categoriesevents.index')
                         ->with('success', 'Kategori kegiatan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit kategori kegiatan
     */
    public function edit(Category $categoriesevent)
    {
        return view('admin.categories.events.edit', compact('categoriesevent'));
    }

    /**
     * Update kategori kegiatan
     */
    public function update(Request $request, Category $categoriesevent)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $categoriesevent->id,
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->only('name', 'description');

        // Update slug jika nama berubah
        if ($categoriesevent->name !== $request->name || $request->slug) {
            $slug = $request->slug ?: Str::slug($request->name);
            $count = Category::where('slug', 'like', "$slug%")
                ->where('id', '!=', $categoriesevent->id)
                ->count();
            $data['slug'] = $count ? "{$slug}-" . ($count + 1) : $slug;
        }

        $categoriesevent->update($data);

        return redirect()->route('admin.categoriesevents.index')
                         ->with('success', 'Kategori kegiatan berhasil diperbarui!');
    }

    /**
     * Hapus kategori kegiatan
     */
    public function destroy(Category $categoriesevent)
    {
        $categoriesevent->delete();

        return redirect()->route('admin.categoriesevents.index')
                         ->with('success', 'Kategori kegiatan berhasil dihapus!');
    }
}

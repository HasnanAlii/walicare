<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\ProgramCategory;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //   public function __construct()
    // {
    //     $this->middleware(['role_or_permission:Superadmin|Program Manager|manage programs']);
    // }
    /**
     * Tampilkan daftar semua kategori program.
     */
    public function index()
    {
        $categories = ProgramCategory::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Tampilkan form untuk menambah kategori baru.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);

        ProgramCategory::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

   
    /**
     * Tampilkan form edit kategori.
     */
    public function edit(ProgramCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Perbarui kategori di database.
     */
    public function update(UpdateCategoryRequest $request, ProgramCategory $category)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori dari database.
     */
    public function destroy(ProgramCategory $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}

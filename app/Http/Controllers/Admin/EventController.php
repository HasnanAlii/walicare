<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Tampilkan semua event (dengan kategori & paginasi)
     */
    public function index()
    {
        $events = Event::with('category')
            ->latest()
            ->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Form tambah event
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.events.create', compact('categories'));
    }

    /**
     * Simpan event baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = $request->only([
            'category_id', 'title', 'description', 'start_date', 'end_date', 'location', 'is_active'
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        // Generate slug unik
        $slug = Str::slug($request->title);
        $count = Event::where('slug', 'like', "$slug%")->count();
        $data['slug'] = $count ? "{$slug}-" . ($count + 1) : $slug;

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat!');
    }

    /**
     * Detail event
     */
    public function show(Event $event)
    {
        $event->loadCount(['likes', 'comments'])
              ->load(['comments.user', 'category']);

        $comments = $event->comments()
            ->with('user')
            ->latest()
            ->paginate(5);

        $event->is_liked_by_user = Auth::check()
            ? $event->likes()->where('user_id', Auth::id())->exists()
            : false;

        return view('admin.events.show', compact('event', 'comments'));
    }

    /**
     * Form edit event
     */
    public function edit(Event $event)
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * Update event
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = $request->only([
            'category_id', 'title', 'description', 'start_date', 'end_date', 'location', 'is_active'
        ]);

        // Jika ada upload baru, hapus lama
        if ($request->hasFile('image')) {
            if ($event->image && Storage::exists('public/' . $event->image)) {
                Storage::delete('public/' . $event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        // Jika judul diubah, buat slug baru
        if ($event->title !== $request->title) {
            $slug = Str::slug($request->title);
            $count = Event::where('slug', 'like', "$slug%")
                ->where('id', '!=', $event->id)
                ->count();
            $data['slug'] = $count ? "{$slug}-" . ($count + 1) : $slug;
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Hapus event
     */
    public function destroy(Event $event)
    {
        if ($event->image && Storage::exists('public/' . $event->image)) {
            Storage::delete('public/' . $event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }
}

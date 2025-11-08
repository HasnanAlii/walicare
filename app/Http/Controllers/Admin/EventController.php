<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Tampilkan semua event (di-paginate untuk admin)
    public function index()
    {
        $events = Event::latest()->paginate(15); // Diubah dari all()
        return view('admin.events.index', compact('events'));
    }

    // Form tambah event
    public function create()
    {
        return view('admin.events.create');
    }

    // Simpan event baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            // 'coment' dihapus dari sini
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $slug = Str::slug($request->title);
        $count = Event::where('slug', 'like', "$slug%")->count();
        $data['slug'] = $count ? $slug . '-' . ($count + 1) : $slug;

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat!');
    }

    // Tampilkan detail event
    public function show(Event $event)
    {
        // Eager load relasi agar query lebih efisien
        $event->loadCount(['likes', 'comments'])
            ->load(['comments.user']);

        // Ambil komentar terbaru dan paginasi
        $comments = $event->comments()
            ->with('user')
            ->latest()
            ->paginate(5);

        // Cek apakah user sudah menyukai event ini (jika login)
        $isLikedByUser = Auth::check()
            ? $event->likes()->where('user_id', Auth::id())->exists()
            : false;

        // Tambahkan properti dinamis untuk memudahkan di view
        $event->is_liked_by_user = $isLikedByUser;

        return view('admin.events.show', compact('event', 'comments'));
    }


    // Form edit event
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }
    
    // Update event
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255', // Diubah dari nullable
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            // 'coment' dihapus dari sini
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($event->image && Storage::exists('public/' . $event->image)) {
                Storage::delete('public/' . $event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        if ($event->title !== $request->title) {
            $slug = Str::slug($request->title);
            $count = Event::where('slug', 'like', "$slug%")->where('id', '!=', $event->id)->count();
            $data['slug'] = $count ? $slug . '-' . ($count + 1) : $slug;
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diupdate!');
    }

    // Hapus event
    public function destroy(Event $event)
    {
        if ($event->image && Storage::exists('public/' . $event->image)) {
            Storage::delete('public/' . $event->image);
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }
}
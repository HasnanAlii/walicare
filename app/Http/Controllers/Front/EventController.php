<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request; // Import Request
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

public function index(Request $request)
{
    $query = Event::query();

    if ($request->has('search') && $request->search != '') {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }

    $events = $query->withCount(['likes', 'comments'])
        ->latest()
        ->paginate(9)
        ->withQueryString();

    $userLikesOnPage = collect();
    if (Auth::check()) {
        $eventIds = $events->pluck('id');
        $userLikesOnPage = Auth::user()->likes()
            ->where('likeable_type', Event::class)
            ->whereIn('likeable_id', $eventIds)
            ->pluck('likeable_id')
            ->flip();
    }

    $events->each(fn($event) => 
        $event->is_liked_by_user = $userLikesOnPage->has($event->id)
    );

    // 🔹 Ambil kategori + jumlah event
    $categories = Category::withCount('events')->orderBy('name')->get();

    // 🔹 Ambil 3 program unggulan (event paling banyak like)
    $featuredPrograms = Event::withCount('likes')
        ->orderByDesc('likes_count')
        ->take(3)
        ->get();

    return view('front.events.index', compact('events', 'categories', 'featuredPrograms'));
}



   
    public function show(Event $event)
    {
        $event->loadCount(['likes', 'comments']);

        $event->is_liked_by_user = false;
        if (Auth::check()) {
            $event->is_liked_by_user = $event->likes()->where('user_id', Auth::id())->exists();
        }

        $comments = $event->comments()
            ->whereHas('user') 
            ->latest()
            ->paginate(10, ['*'], 'comments_page');

        return view('front.events.show', compact('event', 'comments'));
    }

}
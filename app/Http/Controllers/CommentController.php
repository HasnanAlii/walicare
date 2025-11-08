<?php

namespace App\Http\Controllers;

use App\Models\Event; // Pastikan Anda mengimpor Event
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
   
    /**
     * Simpan komentar baru untuk sebuah Event.
     */
    public function storeEventComment(Request $request, Event $event)
    {
        $request->validate([
            'body' => 'required|string|max:2000', // Batasi panjang komentar
        ]);

        $event->comments()->create([
            'user_id' => Auth::id(), // User yang sedang login
            'body' => $request->body,
        ]);

        return back()->with('success', 'Komentar berhasil diposting!');
    }

}
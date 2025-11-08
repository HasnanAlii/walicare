<?php

namespace App\Http\Controllers;

use App\Models\Event; // Import Event
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
   
    /**
     * Suka atau Batal Suka sebuah Event.
     */
    public function toggleEventLike(Event $event)
    {
        $user = Auth::user();

        // Cari tahu apakah user sudah 'like' event ini
        $like = $event->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // Jika sudah ada, hapus (Batal Suka)
            $like->delete();
            $isLiked = false;
        } else {
            // Jika belum ada, buat (Suka)
            $event->likes()->create(['user_id' => $user->id]);
            $isLiked = true;
        }

        // Ambil jumlah 'like' terbaru
        $likesCount = $event->likes()->count();

        // Kembalikan response JSON yang akan dibaca oleh JavaScript
        return response()->json([
            'is_liked' => $isLiked,
            'likes_count' => $likesCount,
        ]);
    }

    // Anda bisa tambahkan fungsi toggleProgramLike() di sini nanti
}
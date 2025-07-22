<?php

namespace App\Http\Controllers;

use App\Models\Confession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home()
    {

        $currentDateTime = Carbon::now()->format('D d M Y, h:i A');

        // Ambil data confession terbaru (misalnya 20 data terakhir)
        $confessions = Confession::latest()
            ->take(20)
            ->get()
            ->map(function ($confession) {
                return [
                    'id' => $confession->id,
                    'recipient_name' => $confession->recipient_name,
                    'message' => $confession->message,
                    'sender_name' => $confession->sender_name,
                    'song_id' => $confession->song_id,
                    'song_title' => $confession->song_title,
                    'song_artist' => $confession->song_artist,
                    'song_image' => $confession->song_image,
                    'created_at' => $confession->created_at->format('D d M Y'),
                    // Tambahkan field lain yang diperlukan
                ];
            });

        return Inertia::render('Welcome', [
            'currentDateTime' => $currentDateTime,
            'confessions' => $confessions,
        ]);
    }

    public function support() {

        return Inertia::render('Support');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Confession;
use App\Services\SpotifyService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SubmitController extends Controller


{
    private $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }
    public function submit()
    {
        $currentDateTime = Carbon::now()->format('D d M Y, h:i A');

        return Inertia::render('Submit', [
            'currentDateTime' => $currentDateTime,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'recipient_name' => 'required|string|max:255',
            'song_id' => 'required|string',
        ], [
            'sender_name.required' => 'Sender required',
            'sender_name.max' => 'Sender maximum 255 characters',
            'message.required' => 'Message is required',
            'message.max' => 'Message maximum 1000 characters',
            'recipient_name.required' => 'Recipient is required',
            'recipient_name.max' => 'Recipient maximum 255 characters',
            'song_id.required' => 'Song is required',
        ]);

        try {
            // Jika ada song_id, ambil detail song dari Spotify
            if (!empty($validated['song_id'])) {
                $songDetails = $this->spotifyService->getTrack($validated['song_id']);

                if ($songDetails) {
                    $validated['song_title'] = $songDetails['title'];
                    $validated['song_artist'] = $songDetails['artist'];
                    $validated['song_image'] = $songDetails['image'];
                    $validated['song_preview_url'] = $songDetails['preview_url'];
                }
            }

            // Simpan data ke database
            Confession::create($validated);

            // Redirect dengan flash message sukses
            return redirect()->route('submit')->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            Log::error('Confession store error: ' . $e->getMessage());
            // Redirect dengan flash message error jika gagal
            return redirect()->route('submit')->with('error', 'Failed to send message. Please try again.');
        }
    }
}

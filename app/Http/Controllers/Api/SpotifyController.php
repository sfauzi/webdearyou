<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SpotifyService;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    private $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return response()->json([
                'data' => []
            ]);
        }

        $tracks = $this->spotifyService->searchTracks($query, 10);

        return response()->json([
            'data' => $tracks
        ]);
    }

    public function getTrack($id)
    {
        $track = $this->spotifyService->getTrack($id);

        if (!$track) {
            return response()->json([
                'error' => 'Track not found'
            ], 404);
        }

        return response()->json([
            'data' => $track
        ]);
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SpotifyService
{
    private $clientId;
    private $clientSecret;
    private $baseUrl = 'https://api.spotify.com/v1';

    public function __construct()
    {
        $this->clientId = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');
    }

    /**
     * Get access token using Client Credentials flow
     */
    private function getAccessToken()
    {
        return Cache::remember('spotify_access_token', 3600, function () {
            $response = Http::asForm()
                ->withBasicAuth($this->clientId, $this->clientSecret)
                ->post('https://accounts.spotify.com/api/token', [
                    'grant_type' => 'client_credentials'
                ]);

            if ($response->successful()) {
                return $response->json()['access_token'];
            }

            throw new \Exception('Failed to get Spotify access token');
        });
    }

    /**
     * Search tracks on Spotify
     */
    public function searchTracks($query, $limit = 20)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->get($this->baseUrl . '/search', [
                    'q' => $query,
                    'type' => 'track',
                    'limit' => $limit,
                    'market' => 'ID' // Indonesian market
                ]);

            if ($response->successful()) {
                $tracks = $response->json()['tracks']['items'];

                return collect($tracks)->map(function ($track) {
                    return [
                        'id' => $track['id'],
                        'title' => $track['name'],
                        'artist' => implode(', ', array_column($track['artists'], 'name')),
                        'image' => $track['album']['images'][0]['url'] ?? null,
                        'preview_url' => $track['preview_url'],
                        'spotify_url' => $track['external_urls']['spotify'],
                    ];
                });
            }

            return collect();
        } catch (\Exception $e) {
            Log::error('Spotify API Error: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get track details by ID
     */
    public function getTrack($trackId)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->get($this->baseUrl . "/tracks/{$trackId}", [
                    'market' => 'ID'
                ]);

            if ($response->successful()) {
                $track = $response->json();

                return [
                    'id' => $track['id'],
                    'title' => $track['name'],
                    'artist' => implode(', ', array_column($track['artists'], 'name')),
                    'image' => $track['album']['images'][0]['url'] ?? null,
                    'preview_url' => $track['preview_url'],
                    'spotify_url' => $track['external_urls']['spotify'],
                ];
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Spotify API Error: ' . $e->getMessage());
            return null;
        }
    }
}

<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Confession>
 */
class ConfessionFactory extends Factory
{
    // Array nama Indonesia
    private $indonesianNames = [
        'Andi', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Galih', 'Hani', 'Indra', 'Joko',
        'Kartika', 'Lukman', 'Maya', 'Nanda', 'Ovi', 'Putri', 'Qori', 'Rina', 'Sari', 'Tono',
        'Uli', 'Vina', 'Widi', 'Yanto', 'Zahra', 'Ayu', 'Bagas', 'Candra', 'Dian', 'Erni',
        'Fajar', 'Gita', 'Hendra', 'Ika', 'Jihan', 'Kiki', 'Lina', 'Mega', 'Nisa', 'Omar',
        'Pandu', 'Qila', 'Reza', 'Sinta', 'Tari', 'Umar', 'Vera', 'Wahyu', 'Yuli', 'Zaki'
    ];

    // Array nama internasional
    private $internationalNames = [
        'Alexander', 'Sophia', 'James', 'Emma', 'William', 'Olivia', 'Benjamin', 'Ava', 'Lucas', 'Isabella',
        'Henry', 'Mia', 'Theodore', 'Charlotte', 'Jack', 'Amelia', 'Owen', 'Harper', 'Liam', 'Evelyn',
        'Noah', 'Abigail', 'Oliver', 'Emily', 'Elijah', 'Madison', 'Mason', 'Scarlett', 'Logan', 'Grace',
        'Ethan', 'Chloe', 'Sebastian', 'Victoria', 'Aiden', 'Riley', 'Jackson', 'Aria', 'Connor', 'Lily',
        'Samuel', 'Natalie', 'David', 'Zoe', 'Joseph', 'Hannah', 'Carter', 'Layla', 'Wyatt', 'Mila'
    ];

    // Array pesan bahasa Indonesia
    private $indonesianMessages = [
        'Selamat ulang tahun! Semoga hari-harimu selalu dipenuhi kebahagiaan dan kesuksesan.',
        'Lagu ini mengingatkanku padamu. Semoga kamu selalu bahagia ya!',
        'Terima kasih sudah menjadi teman yang luar biasa. Kamu selalu ada saat aku membutuhkan.',
        'Hari ini aku teringat masa-masa indah kita bersama. Miss you!',
        'Semoga impianmu segera terwujud. Aku yakin kamu pasti bisa!',
        'Lagu ini cocok banget sama suasana hati hari ini. Dengerin ya!',
        'Maaf kalau aku jarang kabar. Tapi kamu selalu ada di pikiran aku.',
        'Selamat atas pencapaianmu! Kamu memang luar biasa.',
        'Jangan lupa istirahat yang cukup ya. Kesehatan itu penting banget.',
        'Lagu ini bikin aku semangat. Semoga kamu juga ikut semangat!',
        'Kangen masa-masa SMA dulu. Kapan kita reunion lagi nih?',
        'Terima kasih sudah mendengarkan curhatanku kemarin. You\'re the best!',
        'Ayo semangat! Masa sulit pasti akan berlalu.',
        'Lagu ini hits banget sekarang. Wajib masuk playlist kamu!',
        'Selamat menjalani hari yang baru. Semoga penuh berkah!'
    ];

    // Array pesan bahasa Inggris
    private $englishMessages = [
        'Happy birthday! Hope your special day is filled with love and laughter.',
        'This song reminds me of you. Hope you\'re doing great!',
        'Thank you for being such an amazing friend. You always brighten my day.',
        'Missing our good old times together. Can\'t wait to see you again!',
        'Wishing you all the best in your new journey. You got this!',
        'This song is perfect for today\'s mood. Give it a listen!',
        'Sorry for being MIA lately. But you\'re always in my thoughts.',
        'Congratulations on your achievement! So proud of you.',
        'Don\'t forget to take care of yourself. Your health matters.',
        'This song gives me so much energy. Hope it does the same for you!',
        'Remember when we used to jam to this song? Good times!',
        'Thanks for always being there when I need someone to talk to.',
        'Stay strong! Better days are coming your way.',
        'This song is trending right now. Perfect for your playlist!',
        'Have a wonderful day ahead. You deserve all the happiness!'
    ];

    // Array Spotify Track IDs (contoh - ganti dengan ID real)
    private $spotifyTracks = [
        // Pop Hits
        ['id' => '4iV5W9uYEdYUVa79Axb7Rh', 'title' => 'Flowers', 'artist' => 'Miley Cyrus'],
        ['id' => '1BxfuPKGuaTgP7aM0Bbdwr', 'title' => 'Cruel Summer', 'artist' => 'Taylor Swift'],
        ['id' => '0VjIjW4GlULA3N8n9xObKN', 'title' => 'As It Was', 'artist' => 'Harry Styles'],
        ['id' => '4Dvkj6JhhA12EX05fT7y2e', 'title' => 'Anti-Hero', 'artist' => 'Taylor Swift'],
        ['id' => '5sdQOyqq2IDhvmx2lHOpwd', 'title' => 'Bad Habit', 'artist' => 'Steve Lacy'],
        
        // Indonesian Pop
        ['id' => '6rPO02ozF3bM7NnOV4h6s2', 'title' => 'Lathi', 'artist' => 'Weird Genius'],
        ['id' => '2plbrEY59IikOBgBGLjaoe', 'title' => 'Dadu', 'artist' => 'Tulus'],
        ['id' => '1Je1IMUlBXcx1Fz0WE7oPT', 'title' => 'Hati-Hati di Jalan', 'artist' => 'Tulus'],
        ['id' => '0ayqy0VZhZ7LSsGsNgzMHO', 'title' => 'Pesan Dari Hati', 'artist' => 'Jamrud'],
        ['id' => '5uQ0vKy2973Y9IUCd1wMEF', 'title' => 'Risalah Hati', 'artist' => 'Dewa 19'],
        
        // Rock Classics
        ['id' => '4u7EnebtmKWzUH433cf5Qv', 'title' => 'Bohemian Rhapsody', 'artist' => 'Queen'],
        ['id' => '5CQ30WqJwcep0pYcV4AMNc', 'title' => 'Stairway to Heaven', 'artist' => 'Led Zeppelin'],
        ['id' => '4VqPOruhp5EdPBeR92t6lQ', 'title' => 'Imagine', 'artist' => 'John Lennon'],
        ['id' => '3AhXZa8sUQht0UEdBJgpGc', 'title' => 'Hotel California', 'artist' => 'Eagles'],
        ['id' => '32OlwWuMpZ6b0aN2RZOeMS', 'title' => 'Sweet Child O\' Mine', 'artist' => 'Guns N\' Roses'],
        
        // Hip Hop
        ['id' => '7ytR5pFWmSjzHJIeQkgog4', 'title' => 'HUMBLE.', 'artist' => 'Kendrick Lamar'],
        ['id' => '3DK6m7It6Pw857FcQftMds', 'title' => 'Sicko Mode', 'artist' => 'Travis Scott'],
        ['id' => '4f9iBmdUOcunLY7m82ZiMC', 'title' => 'Old Town Road', 'artist' => 'Lil Nas X'],
        ['id' => '2WfaOiMkCvy7F5fcp2zZ8L', 'title' => 'Sunflower', 'artist' => 'Post Malone'],
        ['id' => '0sf4P3mwGHFLbOZNnNyDv0', 'title' => 'God\'s Plan', 'artist' => 'Drake'],
        
        // R&B
        ['id' => '2z8WuEywRWYTKe1NybPQEW', 'title' => 'Levitating', 'artist' => 'Dua Lipa'],
        ['id' => '4iJyoBOLtHqaGxP12qzhQI', 'title' => 'Peaches', 'artist' => 'Justin Bieber'],
        ['id' => '7MXVkk9YMctZqd1Srtv4MB', 'title' => 'Starboy', 'artist' => 'The Weeknd'],
        ['id' => '1mWdTewIgB3gtBM3TOSFhB', 'title' => 'Blinding Lights', 'artist' => 'The Weeknd'],
        ['id' => '6DCZcSspjsKoFjzjrWoCdn', 'title' => 'Good 4 U', 'artist' => 'Olivia Rodrigo'],
        
        // Alternative/Indie
        ['id' => '11dFghVXANMlKmJXsNCbNl', 'title' => 'Rather Be', 'artist' => 'Clean Bandit'],
        ['id' => '6habFhsOp2NvshLv26DqMb', 'title' => 'Thunder', 'artist' => 'Imagine Dragons'],
        ['id' => '6RUKPb4LETWmmr3iAEQktW', 'title' => 'Shape of You', 'artist' => 'Ed Sheeran'],
        ['id' => '7qEHsqek33rTcFNT9PFqLf', 'title' => 'Someone You Loved', 'artist' => 'Lewis Capaldi'],
        ['id' => '1BxfuPKGuaTgP7aM0Bbdwr', 'title' => 'Perfect', 'artist' => 'Ed Sheeran'],
    ];

    /**
     * Mendapatkan data track dari Spotify API yang benar-benar sinkron
     */
    private function getSpotifyTrackData($trackId)
    {
        // Cari di data static berdasarkan ID yang EXACT
        $track = collect($this->spotifyTracks)->where('id', $trackId)->first();
        
        if ($track) {
            // Return data yang benar-benar sesuai dengan ID
            return [
                'id' => $track['id'],
                'title' => $track['title'],
                'artist' => $track['artist'],
                // Generate image URL yang konsisten berdasarkan track ID
                'image' => $this->generateSpotifyImageUrl($track['id']),
                'preview_url' => $this->generateSpotifyPreviewUrl($track['id'])
            ];
        }
        
        // Fallback jika track tidak ditemukan
        return [
            'id' => $trackId,
            'title' => 'Unknown Track',
            'artist' => 'Unknown Artist',
            'image' => 'https://via.placeholder.com/640x640/1DB954/FFFFFF?text=Spotify',
            'preview_url' => null
        ];
    }

    /**
     * Generate consistent Spotify image URL
     */
    private function generateSpotifyImageUrl($trackId)
    {
        // Mapping ID ke image yang real (contoh struktur)
        $imageMapping = [
            '4iV5W9uYEdYUVa79Axb7Rh' => 'https://i.scdn.co/image/ab67616d0000b273316b4c9e6c2654b3a6a69a14',
            '1BxfuPKGuaTgP7aM0Bbdwr' => 'https://i.scdn.co/image/ab67616d0000b273e787cffec20aa2a396a61647',
            '0VjIjW4GlULA3N8n9xObKN' => 'https://i.scdn.co/image/ab67616d0000b273b46f74097655d7f353caab14',
            '4Dvkj6JhhA12EX05fT7y2e' => 'https://i.scdn.co/image/ab67616d0000b273bb54dde68cd23e2a268ae0f5',
            '5sdQOyqq2IDhvmx2lHOpwd' => 'https://i.scdn.co/image/ab67616d0000b27355d0265cc488c4b9cf45f66c',
        ];

        return $imageMapping[$trackId] ?? "https://i.scdn.co/image/ab67616d0000b273" . substr(md5($trackId), 0, 32);
    }

    /**
     * Generate consistent Spotify preview URL
     */
    private function generateSpotifyPreviewUrl($trackId)
    {
        // Preview URL yang konsisten berdasarkan track ID
        $previewMapping = [
            '4iV5W9uYEdYUVa79Axb7Rh' => 'https://p.scdn.co/mp3-preview/879c78f55b8c5b7d2c2c16e2c24f5c1234567890',
            '1BxfuPKGuaTgP7aM0Bbdwr' => 'https://p.scdn.co/mp3-preview/a1b2c3d4e5f6789012345678901234567890abcd',
            '0VjIjW4GlULA3N8n9xObKN' => 'https://p.scdn.co/mp3-preview/b2c3d4e5f6789012345678901234567890abcdef',
        ];

        return $previewMapping[$trackId] ?? "https://p.scdn.co/mp3-preview/" . substr(md5($trackId), 0, 32);
    }

    /**
     * Mendapatkan nama secara random (campuran Indo dan Internasional)
     */
    private function getRandomName()
    {
        $useIndonesian = $this->faker->boolean(60); // 60% chance Indonesian name
        
        if ($useIndonesian) {
            return $this->faker->randomElement($this->indonesianNames);
        } else {
            return $this->faker->randomElement($this->internationalNames);
        }
    }

    /**
     * Mendapatkan pesan secara random (campuran Indo dan Inggris)
     */
    private function getRandomMessage()
    {
        $useIndonesian = $this->faker->boolean(70); // 70% chance Indonesian message
        
        if ($useIndonesian) {
            return $this->faker->randomElement($this->indonesianMessages);
        } else {
            return $this->faker->randomElement($this->englishMessages);
        }
    }

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Random date between June 1, 2025 and July 21, 2025
        $startDate = Carbon::create(2025, 6, 1, 0, 0, 0);
        $endDate = Carbon::create(2025, 7, 21, 23, 59, 59);
        $randomDate = $this->faker->dateTimeBetween($startDate, $endDate);

        // Pilih random track dari Spotify - AMBIL ID DULU
        $randomTrack = $this->faker->randomElement($this->spotifyTracks);
        $selectedTrackId = $randomTrack['id']; // Ambil ID yang akan digunakan
        
        // Dapatkan semua data berdasarkan ID yang SAMA
        $spotifyData = $this->getSpotifyTrackData($selectedTrackId);

        return [
            'recipient_name' => $this->getRandomName(),
            'message' => $this->getRandomMessage(),
            'sender_name' => $this->getRandomName(),
            'song_id' => $spotifyData['id'], // Pastikan sama dengan yang dipilih
            'song_title' => $spotifyData['title'], // Title sesuai dengan ID
            'song_artist' => $spotifyData['artist'], // Artist sesuai dengan ID  
            'song_image' => $spotifyData['image'], // Image sesuai dengan ID
            'song_preview_url' => $spotifyData['preview_url'], // Preview sesuai dengan ID
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ];
    }
}

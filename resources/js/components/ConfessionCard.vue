<template>
    <div
        class="bg-white rounded-xl border border-gray-200 shadow-md mx-2 min-w-[420px] max-w-[420px] flex-shrink-0 hover:shadow-md transition-all duration-300 cursor-pointer overflow-hidden">

        <!-- Main Content -->
        <div class="p-6">
            <!-- Header -->
            <div class="text-left text-base text-slate-500 mb-3">
                hello <span class="text-xl font-milo font-bold text-slate-950">{{ confession.recipient_name }}</span>
            </div>

            <!-- Message -->
            <div class="text-left text-base text-slate-500 mb-6">
                i want to say,
                <span class="text-xl font-milo font-bold text-slate-950 block mt-1 leading-relaxed">
                    {{ truncateMessage(confession.message, 80) }}
                </span>
            </div>

            <!-- Footer -->
            <div class="flex justify-between items-center">
                <span class="text-slate-800 font-milo font-black text-lg">{{ confession.sender_name }}</span>
                <span class="text-slate-500 text-sm font-medium">{{ confession.created_at }}</span>
            </div>
        </div>

        <!-- Song Section -->
        <div class="border-t border-gray-200 bg-gray-100/80 px-6 py-4">
            <div class="flex items-center justify-between">

                <!-- Song Info -->
                <div class="flex items-center flex-1 min-w-0">
                    <div class="flex-shrink-0">
                        <img :src="confession.song_image || '/images/default-song.jpg'" alt="Album Cover"
                            class="w-12 h-12 rounded-full shadow-sm object-cover border border-gray-200"
                            @error="handleImageError" />
                    </div>
                    <div class="ml-3 min-w-0 flex-1">
                        <div class="font-bold text-slate-800 text-sm truncate">
                            {{ confession.song_title || 'Unknown Song' }}
                        </div>
                        <div class="text-xs font-medium text-slate-600 truncate mt-0.5">
                            {{ confession.song_artist || 'Unknown Artist' }}
                        </div>
                    </div>
                </div>

                <!-- Spotify Button -->
                <div class="flex-shrink-0 ml-4">
                    <button class="hover:scale-105 transition-transform duration-200 active:scale-95">
                        <img src="/images/spotify.svg" alt="Play on Spotify"
                            class="w-10 h-10 opacity-90 hover:opacity-100 transition-opacity">
                    </button>
                </div>

            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
interface Confession {
    id: number;
    recipient_name: string;
    message: string;
    sender_name: string;
    song_id: string;
    song_title: string;
    song_artist: string;
    song_image: string;
    created_at: string;
}

defineProps<{
    confession: Confession;
}>();

// Function to truncate message
const truncateMessage = (message: string, maxLength: number): string => {
    if (message.length <= maxLength) return message;
    return message.substring(0, maxLength) + '...';
};

// Handle image error (fallback to default)
const handleImageError = (event: Event) => {
    const target = event.target as HTMLImageElement;
    target.src = '/images/default-song.jpg';
};


</script>
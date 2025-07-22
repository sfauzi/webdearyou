<script setup lang="ts">
import MasterLayout from '@/layouts/MasterLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { defineProps, ref, computed } from 'vue';
import Marquee from '@/components/Marquee.vue';
import ConfessionCard from '@/components/ConfessionCard.vue';


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

const props = defineProps<{
    currentDateTime: string;
    confessions: Confession[];
}>();

const spotifyModal = ref<HTMLElement | null>(null);

const openModal = () => {
    spotifyModal.value?.classList.remove('hidden');
};

const closeModal = () => {
    spotifyModal.value?.classList.add('hidden');
};

// Split confessions into two arrays for two marquee rows
const firstRowConfessions = computed(() => {
    return props.confessions.filter((_, index) => index % 2 === 0);
});

const secondRowConfessions = computed(() => {
    return props.confessions.filter((_, index) => index % 2 === 1);
});

</script>

<template>

    <Head title="For everything you couldn’t say">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <MasterLayout>
        <div
            class="container mx-auto px-4 py-8 flex flex-col items-center justify-center text-center max-w-2xl sm:max-w-3xl md:max-w-5xl lg:max-w-7xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-slate-800 font-milo leading-tight">
                dear you,<br>
                <span class="block">for everything you couldn't say</span>
            </h1>
            <p class="max-w-2xl text-base sm:text-lg text-slate-700 mb-6">
                let your love, your apology, your gratitude all the words left unspoken find their voice through a
                heartfelt message.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 font-semibold w-full sm:w-auto">
                <Link :href="route('submit')"
                    class="px-6 py-2 bg-slate-900 text-white rounded-md hover:bg-slate-800 transition flex items-center justify-center gap-2 w-full sm:w-auto">
                Tell your story
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
                </svg>
                </Link>
                <Link :href="route('browse')"
                    class="px-6 py-2 border border-gray-300 text-slate-800 rounded-md hover:bg-gray-100 transition flex items-center justify-center gap-2 w-full sm:w-auto">
                Browse the Stories
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" fill="none" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" />
                </svg>
                </Link>
            </div>
        </div>

        <div class="flex justify-center py-10 px-2">
            <div
                class="rounded-xl border shadow-lg border-gray-200 w-full max-w-md sm:max-w-lg md:max-w-xl flex flex-col bg-white">
                <!-- Card Content -->
                <div class="p-4 sm:p-6 flex flex-col">
                    <div class="text-left text-base sm:text-lg text-slate-500 mb-2">
                        hello <span class="text-xl sm:text-2xl font-milo font-bold text-slate-950">anjani</span>
                    </div>
                    <div class="text-left text-base sm:text-lg text-slate-500 mb-4">
                        i want to say, <span class="text-xl sm:text-2xl font-milo font-bold text-slate-950">i hope that
                            one day we can meet again,... i miss you</span>
                    </div>
                    <div class="flex flex-row justify-between items-center mt-6 gap-2">
                        <span class="text-slate-800 font-milo font-black">rahul</span>
                        <span class="text-slate-500 text-xs sm:text-sm">{{ currentDateTime }}</span>
                    </div>

                </div>
                <!-- Card Footer -->
                <div
                    class="flex flex-col sm:flex-row items-center justify-between border-t border-gray-200 px-4 sm:px-6 py-3 sm:py-4 bg-gray-100/80 rounded-b-xl gap-3">

                    <div class="flex justify-between items-center w-full sm:w-auto">
                        <!-- Song info -->
                        <div class="flex items-center">
                            <img src="https://i.scdn.co/image/ab67616d0000b273d9985092cd88bffd97653b58" alt="Image"
                                class="w-11 h-11 sm:w-12 sm:h-12 rounded-full mr-2 sm:mr-3" />
                            <div>
                                <div class="font-bold text-slate-800 text-sm sm:text-base">luther (with sza)</div>
                                <div class="text-xs font-medium text-slate-600">Kendrick Lamar, SZA</div>
                            </div>
                        </div>

                        <!-- Spotify logo on mobile (inline) -->
                        <div class="sm:hidden">
                            <button @click="openModal" class="hover:scale-105 transition">
                                <img :src="'/images/spotify.svg'" alt="Spotify Logo" class="w-12 h-12">
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Spotify -->
                    <div class="hidden sm:flex items-center justify-center w-full sm:w-auto">
                        <button @click="openModal" class="hover:scale-105 transition">
                            <img :src="'/images/spotify.svg'" alt="Spotify Logo" class="w-12 h-12">
                        </button>
                    </div>

                    <!-- Modal -->
                    <div ref="spotifyModal"
                        class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center hidden backdrop-blur-sm">
                        <!-- Modal Card Container -->
                        <div
                            class="bg-white rounded-xl shadow-2xl mx-4 my-4 relative overflow-hidden border border-gray-200 max-w-fit">

                            <!-- Close Button -->
                            <button @click="closeModal"
                                class="absolute top-4 right-4 z-10 bg-white/90 hover:bg-white rounded-full p-2 text-gray-600 hover:text-gray-900 shadow-md transition-all duration-200 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Header Card -->
                            <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 text-white">
                                <div class="flex items-center gap-3">
                                    <div class="bg-white/20 rounded-full p-2">
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.84-.179-.84-.66 0-.42.179-.78.54-.84 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.78.242 1.081zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.3c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.32 11.28-1.08 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg">Now Playing</h3>
                                        <p class="text-white/80 text-sm">Listen on Spotify</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Spotify Embed Container -->
                            <div class="p-6 bg-white">
                                <div class="rounded-lg overflow-hidden shadow-inner border border-gray-100">
                                    <iframe src="https://open.spotify.com/embed/track/45J4avUb9Ni0bnETYaYFVJ?go"
                                        width="100%" height="352" frameborder="0"
                                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                        loading="lazy" class="block">
                                    </iframe>
                                </div>
                            </div>

                            <!-- Footer Card -->
                            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <span class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                        Connected to Spotify
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full py-10 overflow-hidden">
            <!-- First Row - Left to Right -->
            <div class="mb-6">
                <Marquee :pauseOnHover="true" :reverse="false" class="[--duration:60s]">
                    <ConfessionCard v-for="confession in firstRowConfessions" :key="`row1-${confession.id}`"
                        :confession="confession" />
                </Marquee>
            </div>

            <!-- Second Row - Right to Left -->
            <div>
                <Marquee :pauseOnHover="true" :reverse="true" class="[--duration:60s]">
                    <ConfessionCard v-for="confession in secondRowConfessions" :key="`row2-${confession.id}`"
                        :confession="confession" />
                </Marquee>
            </div>
        </div>
    </MasterLayout>
</template>


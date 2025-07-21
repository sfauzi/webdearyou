<script setup lang="ts">

import MasterLayout from '@/layouts/MasterLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { defineProps, ref } from 'vue';

const props = defineProps(['currentDateTime']);

const spotifyModal = ref<HTMLElement | null>(null);

const openModal = () => {
    spotifyModal.value?.classList.remove('hidden');
};

const closeModal = () => {
    spotifyModal.value?.classList.add('hidden');
};

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
                    class="flex flex-col sm:flex-row items-center justify-between border-t border-gray-200 px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 rounded-b-xl gap-3">

                    <div class="flex justify-between items-center w-full sm:w-auto">
                        <!-- Song info -->
                        <div class="flex items-center">
                            <img src="https://i.scdn.co/image/ab67616d0000b273d9985092cd88bffd97653b58" alt="Image"
                                class="w-9 h-9 sm:w-10 sm:h-10 rounded-full mr-2 sm:mr-3" />
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
                        class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center hidden">
                        <div
                            class="bg-white p-2 sm:p-5 rounded-xl shadow-xl w-full max-w-xs sm:max-w-xl relative max-h-[33.5vh] sm:max-h-[46vh]">
                            <!-- Tombol Close -->
                            <button @click="closeModal" class="absolute top-3 right-3 text-gray-700 hover:text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Embed Spotify -->
                            <iframe src="https://open.spotify.com/embed/track/45J4avUb9Ni0bnETYaYFVJ?go" width="100%"
                                height="300" frameborder="0" allowtransparency="true" allow="encrypted-media"
                                class="rounded-lg">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MasterLayout>
</template>

<script setup lang="ts">
import MasterLayout from '@/layouts/MasterLayout.vue';
import SongSelect from '@/pages/SongSelect.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { defineProps } from 'vue';

const props = defineProps(['currentDateTime']); // Menerima currentDateTime dari props
// Type definitions
interface FlashMessage {
    success?: string;
    error?: string;
}

interface PageProps {
    flash: FlashMessage;
    errors: Record<string, string>;
}

interface Song {
    id: string;
    title: string;
    artist: string;
    image: string | null;
    preview_url: string | null;
    spotify_url: string;
}

// Mengambil flash messages dan errors dari page props dengan type assertion
const page = usePage<PageProps>();
const flashMessage = computed(() => (page.props.flash as FlashMessage) || {});
const errors = computed(() => (page.props.errors as Record<string, string>) || {});


// Type definitions untuk form
interface FormData {
    sender_name: string;
    message: string;
    recipient_name: string;
    song_id: string;
}

// Setup form dengan useForm dari Inertia
const form = useForm<FormData>({
    sender_name: '',
    message: '',
    recipient_name: '',
    song_id: '',
});

// Selected song state untuk preview
const selectedSong = ref<Song | null>(null);

// Function untuk submit form
const submitForm = () => {
    form.post(route('submit.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

// Handle song selection
const handleSongSelected = (song: Song | null) => {
    selectedSong.value = song;
};

// Modal
const showModal = ref(false);
const modalSongId = ref<string | null>(null);

const openModal = (songId: string) => {
    showModal.value = true;
    modalSongId.value = songId;
};

const closeModal = () => {
    showModal.value = false;
    modalSongId.value = null;
};

</script>

<template>

    <Head title="Send Your Untold Message" />

    <MasterLayout>
        <!-- Flash Messages -->
        <div class="flex justify-center pt-10 px-2" v-if="flashMessage.success || flashMessage.error">
            <div class="w-full max-w-md sm:max-w-lg md:max-w-xl">
                <!-- Success Message -->
                <div v-if="flashMessage.success"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Success!</p>
                            <p class="text-sm">{{ flashMessage.success }}</p>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div v-if="flashMessage.error"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Error!</p>
                            <p class="text-sm">{{ flashMessage.error }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="flex justify-center py-10 px-2">
            <div
                class="rounded-xl border shadow-lg border-gray-200 w-full max-w-md sm:max-w-lg md:max-w-xl flex flex-col bg-white">
                <!-- Card Content -->
                <div class="p-4 sm:p-6 flex flex-col">
                    <div class="text-left text-base sm:text-lg text-slate-500 mb-2">
                        hello <span class="text-xl sm:text-2xl font-milo font-bold text-slate-950">{{
                            form.recipient_name || 'your recipient' }}</span>
                    </div>
                    <div class="text-left text-base sm:text-lg text-slate-500 mb-4">
                        i want to say, <span class="text-xl sm:text-2xl font-milo font-bold text-slate-950">{{
                            form.message
                            || 'your message' }}</span>
                    </div>
                    <div class="flex flex-row justify-between items-center mt-6 gap-2">
                        <span class="text-slate-800 font-milo font-black">{{ form.sender_name || 'your name' }}</span>
                        <span class="text-slate-500 text-xs sm:text-sm">{{ currentDateTime }}</span>
                    </div>
                </div>

                <!-- Card Footer -->
                <div
                    class="flex flex-col sm:flex-row items-center justify-between border-t border-gray-200 px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 rounded-b-xl gap-3">
                    <div class="flex justify-between items-center w-full sm:w-auto">
                        <!-- Song info -->
                        <div class="flex items-center">
                            <img :src="selectedSong?.image || '/images/logo.svg'"
                                :alt="selectedSong?.title || 'selected songs'"
                                class="w-9 h-9 sm:w-10 sm:h-10 rounded-full mr-2 sm:mr-3" />
                            <div>
                                <div class="font-bold text-slate-800 text-sm sm:text-base">{{ selectedSong?.title ||
                                    'Selected Songs' }}</div>
                                <div class="text-xs font-medium text-slate-600">{{ selectedSong?.artist || 'artist name'
                                }}</div>
                            </div>
                        </div>

                        <!-- Spotify logo on mobile (inline) -->
                        <div class="sm:hidden">
                            <button v-if="selectedSong" @click="openModal(selectedSong.id)"
                                class="transition hover:scale-105">
                                <img :src="'/images/spotify.svg'" alt="Spotify"
                                    class="w-11 h-11 sm:w-12 sm:h-12 text-green-500" />

                            </button>
                        </div>
                    </div>

                    <!-- Spotify logo on desktop -->
                    <div class="hidden sm:flex items-center justify-center w-full sm:w-auto">
                        <button v-if="selectedSong" @click="openModal(selectedSong.id)"
                            class="transition hover:scale-105">
                            <img :src="'/images/spotify.svg'" alt="Spotify"
                                class="w-11 h-11 sm:w-12 sm:h-12 text-green-500" />
                        </button>
                    </div>

                    <!-- Modal -->
                    <div v-if="showModal && selectedSong && modalSongId === selectedSong.id"
                        class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center backdrop-blur-sm">
                        <div
                            class="bg-white rounded-xl shadow-2xl mx-4 my-4 relative overflow-hidden border border-gray-200 max-w-fit">
                            <!-- Tombol Close -->
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

                            <div class="p-6 bg-white">
                                <div class="rounded-lg overflow-hidden shadow-inner border border-gray-100">
                                    <!-- Embed Spotify -->
                                    <iframe v-if="selectedSong"
                                        :src="`https://open.spotify.com/embed/track/${selectedSong.id}`" width="100%"
                                        height="352" frameborder="0"
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

        <!-- Form Section -->
        <div class="flex justify-center pb-10 px-2">
            <form @submit.prevent="submitForm" class="w-full max-w-md sm:max-w-lg md:max-w-xl flex flex-col gap-4">
                <!-- Recipient Name Input -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Recipient</label>
                    <input type="text" v-model="form.recipient_name" placeholder="Recipient Name" :class="[
                        'w-full text-slate-900 border rounded-lg px-3 py-2 text-base focus:outline-none focus:ring-1',
                        errors.recipient_name ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-slate-800'
                    ]" />
                    <p v-if="errors.recipient_name" class="mt-1 text-sm text-red-600">{{ errors.recipient_name }}</p>
                </div>

                <!-- Message Textarea -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Message</label>
                    <textarea v-model="form.message" placeholder="Your Message" :class="[
                        'w-full text-slate-900 border rounded-lg px-3 py-2 text-base focus:outline-none focus:ring-1 resize-none',
                        errors.message ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-slate-800'
                    ]" rows="3"></textarea>
                    <p v-if="errors.message" class="mt-1 text-sm text-red-600">{{ errors.message }}</p>
                </div>

                <!-- Sender Name Input -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Your Name</label>
                    <input type="text" v-model="form.sender_name" placeholder="Your Name" :class="[
                        'w-full text-slate-900 border rounded-lg px-3 py-2 text-base focus:outline-none focus:ring-1',
                        errors.sender_name ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-slate-800'
                    ]" />
                    <p v-if="errors.sender_name" class="mt-1 text-sm text-red-600">{{ errors.sender_name }}</p>
                </div>

                <!-- Song Select -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Choose a Song</label>
                    <SongSelect v-model="form.song_id" :error="errors.song_id" @song-selected="handleSongSelected"
                        placeholder="Search and select a song from Spotify" />
                    <!-- <p v-if="errors.song_id" class="mt-1 text-sm text-red-600">{{ errors.song_id }}</p> -->
                </div>


                <!-- Submit Button -->
                <button type="submit" :disabled="form.processing" :class="[
                    'font-bold py-2 px-4 rounded-lg w-full transition',
                    form.processing
                        ? 'bg-gray-400 text-gray-700 cursor-not-allowed'
                        : 'bg-slate-800 text-white hover:bg-slate-700'
                ]">
                    <span v-if="form.processing">Sending...</span>
                    <span v-else>Submit</span>
                </button>
            </form>
        </div>
    </MasterLayout>
</template>
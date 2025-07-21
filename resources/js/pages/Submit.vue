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
                            <img :src="'/images/spotify.svg'" alt="Spotify"
                                class="w-11 h-11 sm:w-12 sm:h-12 text-green-500" />
                        </div>
                    </div>

                    <!-- Spotify logo on desktop -->
                    <div class="hidden sm:flex items-center justify-center w-full sm:w-auto">
                        <img :src="'/images/spotify.svg'" alt="Spotify"
                            class="w-11 h-11 sm:w-12 sm:h-12 text-green-500" />
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
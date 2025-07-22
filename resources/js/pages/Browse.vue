<script setup lang="ts">
import MasterLayout from '@/layouts/MasterLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps<{
    confessions: {
        id: string;
        recipient_name: string;
        message: string;
        sender_name: string;
        song_id: string;
        song_title: string;
        song_artist: string;
        song_image: string;
        created_at: string;
    }[];
    search: string | null;
    hasMore: boolean;
    currentPage: number;
    totalPages: number;
}>();

const searchQuery = ref(props.search || '');
const confessions = ref([...props.confessions]);
const isLoading = ref(false);
const hasMore = ref(props.hasMore);
const currentPage = ref(props.currentPage);

// Watch untuk perubahan props (ketika search dilakukan)
watch(
    () => props.confessions,
    (newConfessions) => {
        confessions.value = [...newConfessions];
    },
);

watch(
    () => props.hasMore,
    (newHasMore) => {
        hasMore.value = newHasMore;
    },
);

watch(
    () => props.currentPage,
    (newCurrentPage) => {
        currentPage.value = newCurrentPage;
    },
);

// Function untuk submit search
const submitSearch = () => {
    router.visit(route('browse'), {
        method: 'get',
        data: { search: searchQuery.value },
        preserveState: false,
        preserveScroll: false,
    });
};

// Function untuk load more data
const loadMoreData = async () => {
    if (isLoading.value || !hasMore.value) return;

    isLoading.value = true;

    try {
        const nextPage = currentPage.value + 1;
        const response = await axios.get(route('browse.load-more'), {
            params: {
                page: nextPage,
                search: searchQuery.value,
            },
        });

        const data = response.data;

        // Tambahkan data baru ke array existing
        confessions.value = [...confessions.value, ...data.confessions];
        hasMore.value = data.hasMore;
        currentPage.value = data.currentPage;
    } catch (error) {
        console.error('Error loading more data:', error);
    } finally {
        isLoading.value = false;
    }
};

// Infinite scroll handler
const handleScroll = () => {
    const scrollPosition = window.innerHeight + window.scrollY;
    const documentHeight = document.documentElement.offsetHeight;

    // Trigger load more ketika hampir sampai bawah (100px sebelum bottom)
    if (scrollPosition >= documentHeight - 100) {
        loadMoreData();
    }
};

// Setup scroll listener
onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

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
    <MasterLayout>
        <Head title="Browse Untold Stories"></Head>

        <div class="mt-6 flex justify-center px-2">
            <div class="flex w-full max-w-3xl items-center space-x-2 rounded-lg bg-blue-600 px-4 py-3 shadow sm:space-x-3 sm:px-6 sm:py-4">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 flex-shrink-0 text-blue-500 sm:h-6 sm:w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="white" />
                    <path stroke="currentColor" stroke-width="2" d="M12 16v-4m0-4h.01" />
                </svg>
                <div class="flex-1">
                    <div class="text-sm font-semibold text-white sm:text-base">Find Message</div>
                    <div class="text-xs text-white sm:text-sm">Scroll the latest messages or start typing recipient name to find your messages.</div>
                </div>
            </div>
        </div>

        <div class="mt-4 flex justify-center px-2">
            <form @submit.prevent="submitSearch" class="flex w-full max-w-3xl flex-col gap-2 sm:flex-row sm:gap-0">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search recipient name..."
                    class="mr-2 flex-1 rounded-lg border border-gray-300 px-4 py-2 text-sm text-slate-900 focus:outline-none sm:rounded-l-lg sm:text-base"
                />
                <button
                    type="submit"
                    class="mr-2 rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700 sm:rounded-r-lg sm:text-base"
                >
                    Search
                </button>
            </form>
        </div>

        <div class="flex justify-center px-2 py-10">
            <div class="grid w-full max-w-3xl grid-cols-1 gap-6 md:grid-cols-2">
                <div
                    v-for="confession in confessions"
                    :key="confession.id"
                    class="flex h-full flex-col rounded-xl border border-gray-200 bg-white shadow-lg"
                >
                    <!-- Card Content (clickable) -->
                    <Link :href="route('detail', { id: confession.id })" class="flex flex-1 cursor-pointer flex-col p-4 sm:p-6">
                        <div class="mb-2 text-left text-base text-slate-500 sm:text-lg">
                            hello <span class="font-milo text-xl font-bold text-slate-950 sm:text-2xl">{{ confession.recipient_name }}</span>
                        </div>
                        <div class="mb-4 text-left text-base text-slate-500 sm:text-lg">
                            i want to say,
                            <span class="font-milo text-xl font-bold text-slate-950 sm:text-2xl">
                                {{ confession.message.length > 50 ? confession.message.slice(0, 50) + '...' : confession.message }}
                            </span>
                        </div>
                        <div class="mt-6 flex flex-shrink-0 flex-row items-center justify-between gap-2">
                            <span class="font-milo font-black text-slate-800">{{ confession.sender_name }}</span>
                            <span class="text-xs text-slate-500 sm:text-sm">{{
                                new Date(confession.created_at).toLocaleString('en-US', {
                                    weekday: 'short',
                                    day: '2-digit',
                                    month: 'short',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                })
                            }}</span>
                        </div>
                    </Link>
                    <!-- Card Footer (NOT clickable) -->
                    <div
                        class="mt-auto flex flex-col items-center justify-between gap-3 rounded-b-xl border-t border-gray-200 bg-gray-100/80 px-4 py-3 select-none sm:flex-row sm:px-6 sm:py-4"
                    >
                        <div class="flex w-full items-center justify-between sm:w-auto">
                            <!-- Song info -->
                            <div class="flex items-center">
                                <img
                                    :src="confession.song_image"
                                    :alt="confession.song_title"
                                    class="mr-2 h-9 w-9 rounded-full sm:mr-3 sm:h-10 sm:w-10"
                                />
                                <div>
                                    <div class="text-sm font-bold text-slate-800 sm:text-base">{{ confession.song_title }}</div>
                                    <div class="text-xs font-medium text-slate-600">{{ confession.song_artist }}</div>
                                </div>
                            </div>
                            <!-- Spotify logo on mobile (inline) -->
                            <div class="sm:hidden">
                                <button @click="openModal(confession.song_id)" class="transition hover:scale-105">
                                    <img :src="'/images/spotify.svg'" alt="Spotify" class="h-11 w-11 text-green-500 sm:h-12 sm:w-12" />
                                </button>
                            </div>
                        </div>
                        <!-- Spotify logo on desktop -->
                        <div class="hidden w-full items-center justify-center sm:flex sm:w-auto">
                            <button @click="openModal(confession.song_id)" class="transition hover:scale-105">
                                <img :src="'/images/spotify.svg'" alt="Spotify" class="h-11 w-11 text-green-500 sm:h-12 sm:w-12" />
                            </button>
                        </div>

                        <!-- Modal -->
                        <div
                            v-if="showModal && modalSongId === confession.song_id"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                        >
                            <div class="bg-white p-2 sm:p-5 rounded-xl shadow-xl w-full max-w-xs sm:max-w-xl relative max-h-[37.5vh] sm:max-h-[46vh]">
                                <!-- Tombol Close -->
                                <button @click="closeModal" class="absolute top-3 right-3 text-gray-700 hover:text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <!-- Embed Spotify -->
                                <iframe
                                    :src="`https://open.spotify.com/embed/track/${confession.song_id}`"
                                    width="100%"
                                    height="300"
                                    frameborder="0"
                                    allowtransparency="true"
                                    allow="encrypted-media"
                                    class="rounded-lg"
                                >
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading indicator -->
        <div v-if="isLoading" class="flex justify-center py-8">
            <div class="flex items-center space-x-2">
                <div class="h-6 w-6 animate-spin rounded-full border-b-2 border-slate-800"></div>
                <span class="text-slate-600">Loading more messages...</span>
            </div>
        </div>

        <!-- No more data indicator -->
        <div v-if="!hasMore && confessions.length > 0" class="flex justify-center py-8">
            <span class="text-slate-500">No more messages to load</span>
        </div>

        <!-- No messages found -->
        <div v-if="confessions.length === 0 && searchQuery">
            <p class="text-center text-slate-500">
                No messages found for "<strong>{{ searchQuery }}</strong
                >"
            </p>
        </div>

        <!-- No messages at all -->
        <div v-if="confessions.length === 0 && !searchQuery">
            <p class="text-center text-slate-500">No messages available</p>
        </div>
    </MasterLayout>
</template>

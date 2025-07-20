<script setup lang="ts">
import MasterLayout from '@/layouts/MasterLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps<{
    confessions: {
        id: string;
        recipient_name: string;
        message: string;
        sender_name: string;
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
watch(() => props.confessions, (newConfessions) => {
    confessions.value = [...newConfessions];
});

watch(() => props.hasMore, (newHasMore) => {
    hasMore.value = newHasMore;
});

watch(() => props.currentPage, (newCurrentPage) => {
    currentPage.value = newCurrentPage;
});

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
                search: searchQuery.value
            }
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
</script>

<template>
    <MasterLayout>

        <Head title="Browse Stories"></Head>

        <div class="flex justify-center mt-6 px-2">
            <div
                class="bg-blue-600 shadow rounded-lg px-4 py-3 sm:px-6 sm:py-4 flex items-center space-x-2 sm:space-x-3 max-w-2xl w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-blue-500 flex-shrink-0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="white" />
                    <path stroke="currentColor" stroke-width="2" d="M12 16v-4m0-4h.01" />
                </svg>
                <div class="flex-1">
                    <div class="font-semibold text-white text-sm sm:text-base">Find Message</div>
                    <div class="text-white text-xs sm:text-sm">
                        Scroll the latest messages or start typing recipient name to find your messages.
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-4 px-2">
            <form @submit.prevent="submitSearch" class="flex max-w-2xl w-full flex-col sm:flex-row gap-2 sm:gap-0">
                <input v-model="searchQuery" type="text" placeholder="Search recipient name..."
                    class="flex-1 px-4 py-2 rounded-lg sm:rounded-l-lg border border-gray-300 focus:outline-none text-slate-900 text-sm sm:text-base mr-2" />
                <button type="submit"
                    class="px-4 py-2 bg-slate-800 text-white font-semibold rounded-lg sm:rounded-r-lg hover:bg-slate-700 transition text-sm sm:text-base mr-2">
                    Search
                </button>
            </form>
        </div>

        <div class="flex justify-center py-10 px-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-2xl">
                <Link v-for="confession in confessions" :key="confession.id"
                    :href="route('detail', { id: confession.id })"
                    class="rounded-xl border shadow-lg border-gray-200 flex flex-col bg-white">
                <!-- Card Content -->
                <div class="p-4 sm:p-6 flex flex-col">
                    <div class="text-left text-base sm:text-lg text-slate-500 mb-2">
                        hello <span class="text-xl sm:text-2xl font-milo font-bold text-slate-950">{{
                            confession.recipient_name }}</span>
                    </div>
                    <div class="text-left text-base sm:text-lg text-slate-500 mb-4">
                        i want to say, <span class="text-xl sm:text-2xl font-milo font-bold text-slate-950">{{
                            confession.message }} </span>
                    </div>
                    <div class="flex flex-row justify-between items-center mt-6 gap-2">
                        <span class="text-slate-800 font-milo font-black">{{ confession.sender_name }}</span>
                        <span class="text-slate-500 text-xs sm:text-sm">{{ new
                            Date(confession.created_at).toLocaleString('en-US', {
                                weekday: 'short',
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            }) }}</span>
                    </div>
                </div>
                <!-- Card Footer -->
                <div
                    class="flex flex-col sm:flex-row items-center justify-between border-t border-gray-200 px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 rounded-b-xl gap-3">
                    <div class="flex justify-between items-center w-full sm:w-auto">
                        <!-- Song info -->
                        <div class="flex items-center">
                            <img src="https://i.scdn.co/image/ab67616d0000b273fb8b07d29db0c456d7449e14" alt="Image"
                                class="w-9 h-9 sm:w-10 sm:h-10 rounded-full mr-2 sm:mr-3" />
                            <div>
                                <div class="font-bold text-slate-800 text-sm sm:text-base">Past Life</div>
                                <div class="text-xs font-medium text-slate-600">Tame Impala</div>
                            </div>
                        </div>
                        <!-- Spotify logo on mobile (inline) -->
                        <div class="sm:hidden">
                            <svg viewBox="0 0 168 168" class="w-6 h-6 text-green-500 ml-3" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="84" cy="84" r="84" fill="#000" />
                                <path
                                    d="M119.7 115.1c-1.7 2.8-5.3 3.7-8.1 2.1-22.2-13.6-50.2-16.7-83.2-9.3-3.2.7-6.4-1.3-7.1-4.5-.7-3.2 1.3-6.4 4.5-7.1 35.3-7.8 65.2-4.2 89.2 10.5 2.8 1.7 3.7 5.3 2.1 8.3zm11.6-23.6c-2.1 3.4-6.5 4.5-9.9 2.4-25.4-15.6-64.2-20.1-94.2-11.2-3.7 1-7.5-1.1-8.5-4.8-1-3.7 1.1-7.5 4.8-8.5 33.7-9.6 75.1-4.7 103.2 12.2 3.4 2.1 4.5 6.5 2.4 9.9zm0-25.2c-29.1-17.3-77.2-18.9-104.2-10.6-4.2 1.2-8.6-1.2-9.8-5.4-1.2-4.2 1.2-8.6 5.4-9.8 30.9-8.9 83.2-7.2 115.6 11.6 3.8 2.2 5.1 7.1 2.9 10.9-2.2 3.8-7.1 5.1-10.9 2.9z"
                                    fill="#fff" />
                            </svg>
                        </div>
                    </div>
                    <!-- Spotify logo on desktop -->
                    <div class="hidden sm:flex items-center justify-center w-full sm:w-auto">
                        <svg viewBox="0 0 168 168" class="w-7 h-7 sm:w-8 sm:h-8 text-green-500" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="84" cy="84" r="84" fill="#000" />
                            <path
                                d="M119.7 115.1c-1.7 2.8-5.3 3.7-8.1 2.1-22.2-13.6-50.2-16.7-83.2-9.3-3.2.7-6.4-1.3-7.1-4.5-.7-3.2 1.3-6.4 4.5-7.1 35.3-7.8 65.2-4.2 89.2 10.5 2.8 1.7 3.7 5.3 2.1 8.3zm11.6-23.6c-2.1 3.4-6.5 4.5-9.9 2.4-25.4-15.6-64.2-20.1-94.2-11.2-3.7 1-7.5-1.1-8.5-4.8-1-3.7 1.1-7.5 4.8-8.5 33.7-9.6 75.1-4.7 103.2 12.2 3.4 2.1 4.5 6.5 2.4 9.9zm0-25.2c-29.1-17.3-77.2-18.9-104.2-10.6-4.2 1.2-8.6-1.2-9.8-5.4-1.2-4.2 1.2-8.6 5.4-9.8 30.9-8.9 83.2-7.2 115.6 11.6 3.8 2.2 5.1 7.1 2.9 10.9-2.2 3.8-7.1 5.1-10.9 2.9z"
                                fill="#fff" />
                        </svg>
                    </div>
                </div>
                </Link>
            </div>
        </div>

        <!-- Loading indicator -->
        <div v-if="isLoading" class="flex justify-center py-8">
            <div class="flex items-center space-x-2">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-slate-800"></div>
                <span class="text-slate-600">Loading more messages...</span>
            </div>
        </div>

        <!-- No more data indicator -->
        <div v-if="!hasMore && confessions.length > 0" class="flex justify-center py-8">
            <span class="text-slate-500">No more messages to load</span>
        </div>

        <!-- No messages found -->
        <div v-if="confessions.length === 0 && searchQuery">
            <p class="text-slate-500 text-center">
                No messages found for "<strong>{{ searchQuery }}</strong>"
            </p>
        </div>

        <!-- No messages at all -->
        <div v-if="confessions.length === 0 && !searchQuery">
            <p class="text-slate-500 text-center">
                No messages available
            </p>
        </div>
    </MasterLayout>
</template>
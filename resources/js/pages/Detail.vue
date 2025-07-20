<script setup lang="ts">
import MasterLayout from '@/layouts/MasterLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    confession: {
        type: Object,
        required: true
    }
});



</script>

<template>

    <Head title="Detail">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <MasterLayout>
        <div class="flex flex-col items-center justify-center min-h-screen px-2 py-6 sm:py-0">
            <div class="flex justify-center pb-6 sm:pb-10 w-full">
                <div class="rounded-xl border shadow-lg border-gray-200 w-full max-w-2xl flex flex-col bg-white">
                    <!-- Card Content -->
                    <div class="p-3 sm:p-6 flex flex-col">
                        <div class="text-left text-base sm:text-lg text-slate-500 mb-2">
                            hello <span class="text-lg sm:text-2xl font-milo font-bold text-slate-950">{{
                                confession.recipient_name }}</span>
                        </div>
                        <div class="text-left text-base sm:text-lg text-slate-500 mb-4 break-words">
                            i want to say, <span class="text-lg sm:text-2xl font-milo font-bold text-slate-950">{{
                                confession.message }}</span>
                        </div>
                        <div class="flex flex-row flex-wrap justify-between items-center mt-6 gap-2">
                            <span class="text-slate-800 font-milo font-black text-sm sm:text-base">{{
                                confession.sender_name }}</span>
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
                    <!--<div
                        class="flex flex-col sm:flex-row items-center justify-between border-t border-gray-200 px-3 sm:px-6 py-3 sm:py-4 bg-gray-50 rounded-b-xl gap-3 w-full">
                        <div class="flex justify-between items-center w-full sm:w-auto">
                            <!~~ Song info ~~>
                            <div class="flex items-center">
                                <img src="https://i.scdn.co/image/ab67616d0000b273fb8b07d29db0c456d7449e14" alt="Image"
                                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-full mr-2 sm:mr-3" />
                                <div>
                                    <div class="font-bold text-slate-800 text-sm sm:text-base">Past Life</div>
                                    <div class="text-xs font-medium text-slate-600">Tame Impala</div>
                                </div>
                            </div>
                            <!~~ Spotify logo on mobile (inline) ~~>
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
                        <!~~ Spotify logo on desktop ~~>
                        <div class="hidden sm:flex items-center justify-center w-full sm:w-auto">
                            <svg viewBox="0 0 168 168" class="w-7 h-7 sm:w-8 sm:h-8 text-green-500" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="84" cy="84" r="84" fill="#000" />
                                <path
                                    d="M119.7 115.1c-1.7 2.8-5.3 3.7-8.1 2.1-22.2-13.6-50.2-16.7-83.2-9.3-3.2.7-6.4-1.3-7.1-4.5-.7-3.2 1.3-6.4 4.5-7.1 35.3-7.8 65.2-4.2 89.2 10.5 2.8 1.7 3.7 5.3 2.1 8.3zm11.6-23.6c-2.1 3.4-6.5 4.5-9.9 2.4-25.4-15.6-64.2-20.1-94.2-11.2-3.7 1-7.5-1.1-8.5-4.8-1-3.7 1.1-7.5 4.8-8.5 33.7-9.6 75.1-4.7 103.2 12.2 3.4 2.1 4.5 6.5 2.4 9.9zm0-25.2c-29.1-17.3-77.2-18.9-104.2-10.6-4.2 1.2-8.6-1.2-9.8-5.4-1.2-4.2 1.2-8.6 5.4-9.8 30.9-8.9 83.2-7.2 115.6 11.6 3.8 2.2 5.1 7.1 2.9 10.9-2.2 3.8-7.1 5.1-10.9 2.9z"
                                    fill="#fff" />
                            </svg>
                        </div>
                    </div>-->
                </div>
            </div>
            <div class="text-slate-800 flex flex-col items-center w-full">
                <h1 class="text-xl sm:text-4xl font-bold mb-3 sm:mb-4 font-milo text-center px-2 sm:px-0">
                    Want to send an apology?
                </h1>

                <Link :href="route('submit')"
                    class="px-6 py-2 bg-slate-900 text-white rounded hover:bg-slate-800 transition flex items-center gap-2">
                Tell your story
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
                </svg>
                </Link>

            </div>
        </div>

    </MasterLayout>

</template>
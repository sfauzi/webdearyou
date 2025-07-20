<script setup lang="ts">
import MasterLayout from '@/layouts/MasterLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { defineProps } from 'vue';


const props = defineProps(['currentDateTime']);

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
            <div class="flex flex-row justify-center gap-4 font-semibold">
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
                <Link :href="route('browse')"
                    class="px-6 py-2 border border-gray-300 text-slate-800 rounded-md hover:bg-gray-100 transition flex items-center gap-2">
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
                        hello <span class="text-xl sm:text-2xl font-milo font-bold text-slate-950">lani</span>
                    </div>
                    <div class="text-left text-base sm:text-lg text-slate-500 mb-4">
                        i want to say, <span class="text-xl sm:text-2xl font-milo font-bold text-slate-950">i hope that
                            one day we can meet again,... i miss you</span>
                    </div>
                    <div class="flex flex-row justify-between items-center mt-6 gap-2">
                        <span class="text-slate-800 font-milo font-black">syah</span>
                        <span class="text-slate-500 text-xs sm:text-sm">{{ currentDateTime }}</span>
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

            </div>
        </div>
    </MasterLayout>
</template>

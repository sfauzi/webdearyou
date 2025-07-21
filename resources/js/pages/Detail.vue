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

    <Head :title="`${confession.recipient_name}`" :description="`Confession from ${confession.sender_name}`">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <MasterLayout>


        <div
            class="container mx-auto px-4 py-8 flex flex-col items-center justify-center text-center max-w-2xl sm:max-w-3xl md:max-w-5xl lg:max-w-7xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-slate-800 font-milo leading-tight">
                dear <span>{{ confession.recipient_name }}</span>,

            </h1>
            <p class="max-w-xl text-base sm:text-lg text-slate-700 mb-6">
                Someone’s sharing a song with you because they believe it’s something you might really enjoy maybe
                it’ll remind you of something special or simply brighten your day.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 font-semibold w-full sm:w-auto">
                <!-- Spotify embed widget -->
                <div class="w-full sm:w-auto flex justify-center items-center mt-2">
                    <iframe v-if="confession.song_id"
                        :src="`https://open.spotify.com/embed/track/${confession.song_id}`" width="400" height="300"
                        frameborder="0" allowtransparency="true" allow="encrypted-media" class="rounded-lg"></iframe>
                </div>

            </div>

            <p class="max-w-xl text-base sm:text-lg text-slate-700 mb-6">
                This is what the sender wants to say to you:
            </p>

            <h3 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 text-slate-800 font-milo leading-tight">
                <span>{{ confession.message }}</span>

            </h3>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-2 mt-2 w-full">
                <span class="font-semibold text-slate-800 font-milo">{{ confession.sender_name }}</span>
                <span class="hidden sm:inline-block text-slate-400">•</span>
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

        <!-- <div class="text-slate-800 flex flex-col items-center w-full">
            <h1 class="text-xl sm:text-4xl font-bold mb-3 sm:mb-4 font-milo text-center px-2 sm:px-0">
                Want to send an apology?
            </h1>

            <Link :href="route('submit')"
                class="px-6 py-2 bg-slate-900 text-white rounded-md hover:bg-slate-800 transition flex items-center gap-2">
            Tell your story
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
            </svg>
            </Link>

        </div> -->


    </MasterLayout>

</template>
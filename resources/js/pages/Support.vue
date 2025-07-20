<script setup lang="ts">
import MasterLayout from '@/layouts/MasterLayout.vue';
import { Head } from '@inertiajs/vue3';


</script>

<template>

    <Head title="DearYou – A Place for the Words Left Unspoken">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <MasterLayout>
        <div
            class="container mx-auto px-4 py-8 flex flex-col items-center justify-center text-center max-w-2xl sm:max-w-3xl md:max-w-5xl lg:max-w-7xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-slate-800 font-milo leading-tight">
                support dear you

            </h1>
            <p class="max-w-2xl text-base sm:text-lg text-slate-700 mb-6">
                DearYou is and will always be completely free to use! However, if you'd like to support the
                development and server costs, you can make a voluntary contribution. Any amount is deeply appreciated
                and helps keep this service running smoothly for everyone :)
            </p>

        </div>
    </MasterLayout>

</template>
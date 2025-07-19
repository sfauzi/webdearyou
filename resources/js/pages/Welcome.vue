<script setup lang="ts">
import MasterLayout from '@/layouts/MasterLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <MasterLayout>
        <div class="container mx-auto mt-8">
            <h1 class="text-3xl font-bold mb-4 text-slate-800">Welcome to MyApp!</h1>
            <p class="text-slate-700">This is the homepage.</p>
        </div>
    </MasterLayout>
</template>

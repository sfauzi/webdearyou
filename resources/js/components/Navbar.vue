<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
</script>


<template>
    <nav class="bg-white shadow-md p-4 text-slate-800">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-xl font-bold">MyApp</div>
            <div class="space-x-4">
                <Link href="/">Home</Link>
                <Link href="/about">About</Link>
            </div>
        </div>
    </nav>
</template>

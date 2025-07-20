<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
</script>


<template>
    <nav class="bg-white border-b-1 border-gray-300 p-4 text-slate-800">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-xl font-bold font-milo">SendTheSong</div>
            <div class="space-x-4">
                <Link href="/">Submit</Link>
                <Link href="/">Browse</Link>
                <Link href="/">History</Link>
                <Link href="/">Support</Link>
            </div>
        </div>
    </nav>
</template>

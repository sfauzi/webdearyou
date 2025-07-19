<script setup lang="ts">

import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'


</script>

<template>
    <div class="min-h-screen flex flex-col bg-white">
        <Navbar />

        <!-- Main Content -->
        <main class="flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
</template>

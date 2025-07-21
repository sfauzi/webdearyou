<template>
    <div class="relative">
        <div class="relative">
            <input type="text" v-model="searchQuery" @input="handleSearch" @focus="showDropdown = true"
                @blur="handleBlur"
                :placeholder="selectedSong ? selectedSong.title + ' - ' + selectedSong.artist : 'Search and select a song'"
                :class="[
                    'w-full text-slate-900 border rounded-lg px-3 py-2 text-base focus:outline-none focus:ring-1 pr-10',
                    error ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-slate-800'
                ]" />

            <!-- Search Icon -->
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Dropdown -->
        <div v-if="showDropdown && (songs.length > 0 || isLoading)"
            class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
            <!-- Loading State -->
            <div v-if="isLoading" class="p-3 text-center text-gray-500">
                <div class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Searching songs...
                </div>
            </div>

            <!-- Song Items -->
            <div v-else-if="songs.length > 0">
                <div v-for="song in songs" :key="song.id" @mousedown="selectSong(song)"
                    class="flex items-center p-3 hover:bg-gray-50 cursor-pointer border-b last:border-b-0">
                    <img :src="song.image || '/default-album.png'" :alt="song.title"
                        class="w-12 h-12 rounded-lg mr-3 object-cover" @error="handleImageError" />
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-slate-900 truncate">{{ song.title }}</div>
                        <div class="text-sm text-slate-600 truncate">{{ song.artist }}</div>
                    </div>
                </div>
            </div>

            <!-- No Results -->
            <div v-else class="p-3 text-center text-gray-500">
                No songs found. Try a different search term.
            </div>
        </div>

        <!-- Error Message -->
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>

        <!-- Selected Song Preview -->
        <div v-if="selectedSong && !showDropdown" class="mt-2 p-3 bg-gray-50 rounded-lg border">
            <div class="flex items-center">
                <img :src="selectedSong.image || '/default-album.png'" :alt="selectedSong.title"
                    class="w-10 h-10 rounded-lg mr-3 object-cover" @error="handleImageError" />
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-slate-900 truncate">{{ selectedSong.title }}</div>
                    <div class="text-sm text-slate-600 truncate">{{ selectedSong.artist }}</div>
                </div>
                <button @click="clearSelection" type="button" class="ml-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import axios from 'axios'

interface Song {
    id: string
    title: string
    artist: string
    image: string | null
    preview_url: string | null
    spotify_url: string
}

interface Props {
    modelValue?: string
    error?: string
    placeholder?: string
}

const props = defineProps<Props>()

const emit = defineEmits<{
    'update:modelValue': [value: string]
    'song-selected': [song: Song | null]
}>()

const searchQuery = ref('')
const songs = ref<Song[]>([])
const selectedSong = ref<Song | null>(null)
const showDropdown = ref(false)
const isLoading = ref(false)
const searchTimeout = ref<number | null>(null)

const handleSearch = () => {
    if (searchTimeout.value) {
        clearTimeout(searchTimeout.value)
    }

    if (searchQuery.value.length < 2) {
        songs.value = []
        showDropdown.value = false
        return
    }

    searchTimeout.value = window.setTimeout(async () => {
        await searchSongs(searchQuery.value)
    }, 300)
}

const searchSongs = async (query: string) => {
    if (!query || query.length < 2) {
        songs.value = []
        return
    }

    isLoading.value = true
    showDropdown.value = true

    try {
        const response = await axios.get('/search', {
            params: { q: query }
        })

        songs.value = response.data.data || []
    } catch (error) {
        console.error('Error searching songs:', error)
        songs.value = []
    } finally {
        isLoading.value = false
    }
}

const selectSong = (song: Song) => {
    selectedSong.value = song
    searchQuery.value = `${song.title} - ${song.artist}`
    showDropdown.value = false

    emit('update:modelValue', song.id)
    emit('song-selected', song)
}

const clearSelection = () => {
    selectedSong.value = null
    searchQuery.value = ''
    emit('update:modelValue', '')
    emit('song-selected', null)
}

const handleBlur = () => {
    // Delay hiding dropdown to allow click events on items
    setTimeout(() => {
        showDropdown.value = false
    }, 150)
}

const handleImageError = (event: Event) => {
    const target = event.target as HTMLImageElement
    target.src = '/default-album.png'
}

// Watch for external changes to modelValue
watch(() => props.modelValue, async (newValue) => {
    if (newValue && !selectedSong.value) {
        // Fetch song details if we have an ID but no selected song
        try {
            const response = await axios.get(`/track/${newValue}`)
            if (response.data.data) {
                selectedSong.value = response.data.data
                searchQuery.value = `${response.data.data.title} - ${response.data.data.artist}`
            }
        } catch (error) {
            console.error('Error fetching song details:', error)
        }
    } else if (!newValue) {
        clearSelection()
    }
})
</script>
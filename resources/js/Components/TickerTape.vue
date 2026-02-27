<script setup>
defineProps({
    history: { type: Array, default: () => [] },
})

const emit = defineEmits(['delete', 'clear'])
</script>

<template>
    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-800">
            <h2 class="text-gray-400 text-sm font-semibold uppercase tracking-wider">History</h2>
            <button
                v-if="history.length > 0"
                class="text-xs text-rose-400 hover:text-rose-300 transition-colors duration-150 font-medium cursor-pointer"
                @click="emit('clear')"
            >
                Clear All
            </button>
        </div>

        <div v-if="history.length === 0" class="px-4 py-8 text-center">
            <p class="text-gray-600 text-sm font-mono">No calculations yet</p>
        </div>

        <div v-else class="max-h-96 overflow-y-auto">
            <div
                v-for="item in history"
                :key="item.id"
                class="flex justify-between items-center px-4 py-3 border-b border-gray-800 last:border-0 hover:bg-gray-800 transition-colors duration-150 group"
            >
                <div class="flex-1 min-w-0 mr-3">
                    <p class="font-mono text-gray-400 text-sm truncate">{{ item.expression }}</p>
                    <p class="font-mono text-white text-sm font-medium">= {{ item.result }}</p>
                </div>
                <button
                    class="text-gray-600 hover:text-rose-400 transition-colors duration-150 opacity-0 group-hover:opacity-100 cursor-pointer shrink-0"
                    @click="emit('delete', item.id)"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

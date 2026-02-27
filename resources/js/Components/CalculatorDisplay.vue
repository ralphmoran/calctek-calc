<script setup>
defineProps({
    expression: { type: String, default: '' },
    result: { type: [Number, String], default: null },
    error: { type: String, default: null },
})
</script>

<template>
    <div class="bg-gray-800/50 rounded-2xl p-6 mb-4 min-h-32 flex flex-col justify-end backdrop-blur-sm">
        <p class="font-mono text-right text-gray-400 text-sm truncate min-h-5">
            {{ expression || '\u00A0' }}
        </p>
        <p class="font-mono text-right text-white text-5xl font-light tracking-tight mt-2 truncate">
            {{ result !== null ? result : '0' }}
        </p>
        <p v-if="error" class="text-rose-400 font-mono text-sm text-right mt-2">
            {{ error }}
        </p>
    </div>
</template>

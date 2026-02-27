<script setup>
const emit = defineEmits(['button-press'])

const rows = [
    [
        { label: '\u221A', value: 'sqrt(', type: 'function' },
        { label: 'x\u207F', value: '^', type: 'function' },
        { label: 'n!', value: '!', type: 'function' },
        { label: 'C', value: 'clear', type: 'clear' },
    ],
    [
        { label: '(', value: '(', type: 'operator' },
        { label: ')', value: ')', type: 'operator' },
        { label: '\u232B', value: 'backspace', type: 'clear' },
        { label: '\u00F7', value: '/', type: 'operator' },
    ],
    [
        { label: '7', value: '7', type: 'number' },
        { label: '8', value: '8', type: 'number' },
        { label: '9', value: '9', type: 'number' },
        { label: '\u00D7', value: '*', type: 'operator' },
    ],
    [
        { label: '4', value: '4', type: 'number' },
        { label: '5', value: '5', type: 'number' },
        { label: '6', value: '6', type: 'number' },
        { label: '\u2212', value: '-', type: 'operator' },
    ],
    [
        { label: '1', value: '1', type: 'number' },
        { label: '2', value: '2', type: 'number' },
        { label: '3', value: '3', type: 'number' },
        { label: '+', value: '+', type: 'operator' },
    ],
    [
        { label: '.', value: '.', type: 'number' },
        { label: '0', value: '0', type: 'number' },
        { label: '00', value: '00', type: 'number' },
        { label: '=', value: 'equals', type: 'equals' },
    ],
]

function buttonClass(type) {
    const base = 'rounded-xl p-4 text-xl transition-colors duration-150 active:scale-95 transition-transform font-mono cursor-pointer select-none'
    switch (type) {
        case 'number':
            return `${base} bg-gray-700 hover:bg-gray-600 text-white`
        case 'operator':
            return `${base} bg-purple-600 hover:bg-purple-500 text-white font-semibold`
        case 'equals':
            return `${base} bg-emerald-500 hover:bg-emerald-400 text-white font-bold`
        case 'function':
            return `${base} bg-indigo-600 hover:bg-indigo-500 text-white font-semibold`
        case 'clear':
            return `${base} bg-rose-600 hover:bg-rose-500 text-white font-semibold`
        default:
            return base
    }
}
</script>

<template>
    <div class="grid grid-cols-4 gap-3">
        <template v-for="(row, ri) in rows" :key="ri">
            <button
                v-for="btn in row"
                :key="btn.value"
                :class="buttonClass(btn.type)"
                @click="emit('button-press', btn.value)"
            >
                {{ btn.label }}
            </button>
        </template>
    </div>
</template>

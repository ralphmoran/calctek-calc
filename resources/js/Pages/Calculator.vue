<script setup>
import { ref, reactive } from 'vue'
import axios from 'axios'
import CalculatorDisplay from '@/Components/CalculatorDisplay.vue'
import CalculatorKeypad from '@/Components/CalculatorKeypad.vue'
import TickerTape from '@/Components/TickerTape.vue'

const props = defineProps({ history: Array })

const expression = ref('')
const result = ref(null)
const error = ref(null)
const loading = ref(false)
const history = reactive([...(props.history ?? [])])

function handleButtonPress(value) {
    error.value = null

    switch (value) {
        case 'clear':
            expression.value = ''
            result.value = null
            error.value = null
            break
        case 'backspace':
            expression.value = expression.value.slice(0, -1)
            break
        case 'equals':
            submit()
            break
        default:
            expression.value += value
    }
}

async function submit() {
    if (!expression.value.trim()) return

    loading.value = true
    error.value = null

    try {
        const { data } = await axios.post('/api/calculations', {
            expression: expression.value,
        })
        result.value = data.data.result
        history.unshift(data.data)
        expression.value = ''
    } catch (e) {
        error.value = e.response?.data?.message ?? 'An unexpected error occurred.'
        result.value = null
    } finally {
        loading.value = false
    }
}

async function deleteCalculation(id) {
    try {
        await axios.delete(`/api/calculations/${id}`)
        const index = history.findIndex(item => item.id === id)
        if (index !== -1) history.splice(index, 1)
    } catch (e) {
        error.value = e.response?.data?.message ?? 'Failed to delete calculation.'
    }
}

async function clearHistory() {
    try {
        await axios.delete('/api/calculations')
        history.splice(0, history.length)
    } catch (e) {
        error.value = e.response?.data?.message ?? 'Failed to clear history.'
    }
}
</script>

<template>
    <div class="min-h-screen bg-gray-950 flex items-start justify-center p-4 md:p-8">
        <div class="flex flex-col md:flex-row gap-6 md:gap-8 w-full max-w-2xl md:items-start">
            <!-- Calculator Panel -->
            <div class="w-full md:max-w-sm">
                <div class="bg-gray-900 rounded-2xl shadow-xl p-5">
                    <CalculatorDisplay
                        :expression="expression"
                        :result="result"
                        :error="error"
                    />
                    <CalculatorKeypad @button-press="handleButtonPress" />
                </div>
            </div>

            <!-- Ticker Panel -->
            <div class="w-full md:max-w-xs">
                <TickerTape
                    :history="history"
                    @delete="deleteCalculation"
                    @clear="clearHistory"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    estado: {
        type: String,
        required: true
    }
})

const getBadgeClass = (estado) => {
    if (estado === 'activo') return 'bg-blue-600/20 text-blue-300 border border-blue-500/30'
    if (estado === 'en_pausa') return 'bg-yellow-600/20 text-yellow-300 border border-yellow-500/30'
    return 'bg-slate-700/40 text-slate-400 border border-slate-600/30'
}
</script>

<template>
    <span :class="['text-xs font-semibold px-3 py-1 rounded-full capitalize', getBadgeClass(estado)]">
        {{ estado.replace('_', ' ') }}
    </span>
</template>
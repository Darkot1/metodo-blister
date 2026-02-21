<script setup>
const props = defineProps({
    show: Boolean,
    title: {
        type: String,
        default: 'Confirmar accion',
    },
    message: {
        type: String,
        default: 'Estas seguro de continuar?',
    },
    confirmText: {
        type: String,
        default: 'Confirmar',
    },
    cancelText: {
        type: String,
        default: 'Cancelar',
    },
    loading: Boolean,
});

const emit = defineEmits(['confirm', 'cancel']);
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/60" @click="emit('cancel')"></div>
        <div class="relative w-full max-w-md rounded-xl border border-white/10 bg-slate-900 p-6 shadow-xl">
            <h3 class="text-lg font-semibold text-white">{{ title }}</h3>
            <p class="mt-2 text-sm text-slate-300">{{ message }}</p>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="emit('cancel')"
                    class="px-4 py-2 rounded-lg border border-slate-600 text-slate-300 hover:text-white hover:border-slate-500 transition">
                    {{ cancelText }}
                </button>
                <button type="button" @click="emit('confirm')" :disabled="loading"
                    class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-500 disabled:bg-slate-600 disabled:cursor-not-allowed transition">
                    {{ loading ? 'Procesando...' : confirmText }}
                </button>
            </div>
        </div>
    </div>
</template>

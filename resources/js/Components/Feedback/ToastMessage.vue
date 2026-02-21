<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    message: String,
    type: {
        type: String,
        default: 'success',
    },
    duration: {
        type: Number,
        default: 3000,
    },
});

const visible = ref(false);
let timer = null;

const close = () => {
    visible.value = false;
    if (timer) {
        clearTimeout(timer);
        timer = null;
    }
};

watch(() => props.message, (value) => {
    if (value) {
        visible.value = true;
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(() => {
            visible.value = false;
            timer = null;
        }, props.duration);
    } else {
        close();
    }
});
</script>

<template>
    <div v-if="visible" class="fixed top-5 right-5 z-50">
        <div class="rounded-lg border border-white/10 bg-slate-900 px-4 py-3 shadow-lg">
            <div class="flex items-center gap-3">
                <div v-if="type === 'success'" class="h-2 w-2 rounded-full bg-emerald-400"></div>
                <div v-else class="h-2 w-2 rounded-full bg-red-400"></div>
                <p class="text-sm text-white">{{ message }}</p>
                <button type="button" @click="close" class="text-slate-400 hover:text-white transition">&times;</button>
            </div>
        </div>
    </div>
</template>

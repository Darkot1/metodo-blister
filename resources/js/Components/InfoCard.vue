<script setup>
defineProps({
    title: {
        type: String,
        required: true
    }
})
</script>

<template>
    <div class="bg-white/5 border border-white/10 rounded-xl p-6">
        <h3 class="text-s uppercase tracking-wider text-blue-300 font-semibold mb-5">
            {{ title }}
        </h3>
        <slot />
    </div>
</template>
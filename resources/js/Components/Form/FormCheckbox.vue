<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: Boolean,
    label: String,
    name: String,
    id: String,
    disabled: Boolean,
    variant: {
        type: String,
        default: 'dark',
    },
});

const emit = defineEmits(['update:modelValue']);

const isLight = computed(() => props.variant === 'light');

const labelClass = computed(() => (isLight.value
    ? 'ms-2 text-sm text-gray-600'
    : 'ms-2 text-sm text-slate-300'));

const checkboxClass = computed(() => (isLight.value
    ? 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500'
    : 'rounded border-white/20 bg-slate-950/60 text-blue-500 focus:ring-blue-600'));
</script>

<template>
    <label class="flex items-center">
        <input :id="id" :name="name" type="checkbox" :checked="modelValue" :disabled="disabled" :class="checkboxClass"
            @change="emit('update:modelValue', $event.target.checked)" />
        <span v-if="label" :class="labelClass">{{ label }}</span>
    </label>
</template>

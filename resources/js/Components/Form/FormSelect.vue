<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: [String, Number],
    label: String,
    error: String,
    id: String,
    name: String,
    required: Boolean,
    disabled: Boolean,
    variant: {
        type: String,
        default: 'dark',
    },
});

const emit = defineEmits(['update:modelValue']);

const isLight = computed(() => props.variant === 'light');

const labelClass = computed(() => (isLight.value
    ? 'block text-sm font-semibold text-gray-700 mb-1.5'
    : 'block text-s font-semibold text-slate-400 mb-1.5'));

const selectClass = computed(() => (isLight.value
    ? 'w-full border border-gray-300 bg-white text-gray-900 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition'
    : 'w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition'));

const errorClass = computed(() => (isLight.value
    ? 'mt-1 text-xs text-red-600'
    : 'mt-1 text-xs text-red-400'));
</script>

<template>
    <div>
        <label v-if="label" :for="id" :class="labelClass">{{ label }}</label>
        <select :id="id" :name="name" :value="modelValue" :required="required" :disabled="disabled" :class="selectClass"
            @change="emit('update:modelValue', $event.target.value)">
            <slot />
        </select>
        <p v-if="error" :class="errorClass">{{ error }}</p>
    </div>
</template>

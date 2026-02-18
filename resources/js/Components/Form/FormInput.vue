<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: [String, Number],
    label: String,
    type: {
        type: String,
        default: 'text',
    },
    placeholder: String,
    error: String,
    id: String,
    name: String,
    required: Boolean,
    autocomplete: String,
    autofocus: Boolean,
    disabled: Boolean,
    step: [String, Number],
    min: [String, Number],
    max: [String, Number],
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

const inputClass = computed(() => (isLight.value
    ? 'w-full border border-gray-300 bg-white text-gray-900 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition placeholder:text-gray-400'
    : 'w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition placeholder:text-slate-700'));

const errorClass = computed(() => (isLight.value
    ? 'mt-1 text-xs text-red-600'
    : 'mt-1 text-xs text-red-400'));
</script>

<template>
    <div>
        <label v-if="label" :for="id" :class="labelClass">{{ label }}</label>
        <input :id="id" :name="name" :type="type" :placeholder="placeholder" :value="modelValue" :required="required"
            :autocomplete="autocomplete" :autofocus="autofocus" :disabled="disabled" :step="step" :min="min" :max="max"
            :class="inputClass" @input="emit('update:modelValue', $event.target.value)" />
        <p v-if="error" :class="errorClass">{{ error }}</p>
    </div>
</template>

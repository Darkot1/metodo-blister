<script setup>
import InfoCard from '@/Components/InfoCard.vue';

const props = defineProps({
    plan: {
        type: Object,
        required: true
    },
    form: {
        type: Object,
        required: true
    },
    sesionesCount: {
        type: Number,
        required: true
    },
    canAddSession: {
        type: Boolean,
        required: true
    },
    isDayAlreadyUsed: {
        type: Boolean,
        required: true
    }
})

const emit = defineEmits(['submit'])

const handleSubmit = () => {
    emit('submit');
}
</script>

<template>
    <InfoCard title="Crear Nueva Sesión">
        <form @submit.prevent="handleSubmit" class="space-y-6">

            <!-- Seleccionar Semana -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Semana <span class="text-red-400">*</span>
                </label>
                <select v-model.number="props.form.numero_semana"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 text-white cursor-pointer focus:outline-none focus:border-blue-500">
                    <option v-for="i in props.plan.numero_semanas" :key="i" :value="i">
                        Semana {{ i }}
                    </option>
                </select>
                <p class="text-slate-400 text-sm mt-2">
                    Sesiones en esta semana: {{ sesionesCount }}/{{ props.plan.frecuencia_semanal }}
                </p>
            </div>

            <!-- Nombre de la Sesión -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Nombre de la Sesión <span class="text-red-400">*</span>
                </label>
                <input v-model="props.form.nombre" type="text" placeholder="Ej: Pecho y Tríceps"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500" />
                <p v-if="props.form.errors.nombre" class="text-red-400 text-sm mt-2">{{ props.form.errors.nombre }}
                </p>
            </div>

            <!-- Día de la Semana -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">
                    Día de la Semana <span class="text-red-400">*</span>
                </label>
                <select v-model="props.form.dia_semana"
                    class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 text-white cursor-pointer focus:outline-none focus:border-blue-500">
                    <option value="">Seleccionar día</option>
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miércoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                    <option value="Sábado">Sábado</option>
                    <option value="Domingo">Domingo</option>
                </select>
                <p v-if="props.form.errors.dia_semana" class="text-red-400 text-sm mt-2">{{
                    props.form.errors.dia_semana }}</p>
                <p v-if="isDayAlreadyUsed" class="text-amber-400 text-sm mt-2">
                    ⚠️ Ya existe una sesión para el {{ props.form.dia_semana }} en esta semana
                </p>
            </div>

            <!-- Estado -->
            <div v-if="!canAddSession" class="bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                <p class="text-red-400 text-sm">
                    Has alcanzado el máximo de {{ props.plan.frecuencia_semanal }} sesiones para la
                    semana {{ props.form.numero_semana }}.
                </p>
            </div>

            <!-- Botones -->
            <div class="flex gap-3 pt-4">
                <button type="submit" :disabled="props.form.processing || !canAddSession"
                    class="flex-1 bg-blue-600 hover:bg-blue-500 disabled:bg-slate-600 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-lg transition">
                    {{ props.form.processing ? 'Creando...' : 'Crear Sesión' }}
                </button>
                <button type="button" @click="$emit('go-back')"
                    class="px-6 py-3 border border-slate-600 hover:border-slate-500 text-slate-300 hover:text-white font-semibold rounded-lg transition">
                    Cancelar
                </button>
            </div>
        </form>
    </InfoCard>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InfoCard from '@/Components/InfoCard.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { ChevronLeftIcon } from '@heroicons/vue/24/outline';
import { usePlan } from '@/Composables/usePlan';

const { formatearFecha } = usePlan();

const props = defineProps({
    plan: {
        type: Object,
        required: true
    },
    sesion: {
        type: Object,
        required: true
    }
})

const form = useForm({
    nombre: props.sesion.nombre || '',
    dia_semana: props.sesion.dia_semana || '',
    numero_semana: props.sesion.numero_semana || 1,
});


const sesionesCount = computed(() => {
    if (!props.plan?.sesiones || !Array.isArray(props.plan.sesiones)) {
        return 0;
    }
    const semanaActual = props.plan.sesiones.filter(s =>
        s.numero_semana === form.numero_semana && s.id !== props.sesion.id
    );
    return semanaActual.length;
});

const sesionesCountTotal = computed(() => sesionesCount.value + 1);

const canAddSession = computed(() => {
    const maxSesiones = props.plan?.frecuencia_semanal || 0;
    return sesionesCount.value < maxSesiones;
});

const isDayAlreadyUsed = computed(() => {
    if (!props.plan?.sesiones || !Array.isArray(props.plan.sesiones)) {
        return false;
    }
    return props.plan.sesiones.some(s =>
        s.id !== props.sesion.id &&
        s.numero_semana === form.numero_semana &&
        s.dia_semana === form.dia_semana
    );
});

const submitForm = () => {
    if (!form.nombre || !form.dia_semana) {
        alert('Por favor completa todos los campos.');
        return;
    }

    if (!canAddSession.value) {
        alert(`Ya has alcanzado el máximo de ${props.plan.frecuencia_semanal} sesiones para la semana ${form.numero_semana}.`);
        return;
    }

    if (isDayAlreadyUsed.value) {
        alert(`Ya existe una sesión para el ${form.dia_semana} en la semana ${form.numero_semana}.`);
        return;
    }

    form.put(route('sesiones-entrenamiento.update', { plan: props.plan.id, sesion: props.sesion.id }));
};

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <AppLayout title="Editar Sesión">
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <button @click="goBack" class="text-slate-400 hover:text-white transition-colors">
                    <ChevronLeftIcon class="w-6 h-6" />
                </button>
                <div>
                    <p class="text-m uppercase tracking-[0.3em] text-blue-300">Plan</p>
                    <h2 class="text-4xl font-display text-white">Editar Sesión - {{ props.plan.nombre }}</h2>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">

                <!-- Columna izquierda -->
                <div class="lg:col-span-1 space-y-6">
                    <InfoCard title="Información del Plan">
                        <div class="space-y-4">
                            <div>
                                <p class="text-s text-slate-500 mb-2">Alumno</p>
                                <p class="text-white font-medium">{{ props.plan.alumno?.nombres }} {{
                                    props.plan.alumno?.apellidos }}</p>
                            </div>
                            <div>
                                <p class="text-s text-slate-500 mb-2">Frecuencia</p>
                                <p class="text-white font-medium">{{ props.plan.frecuencia_semanal }} sesiones/semana
                                </p>
                            </div>
                            <div>
                                <p class="text-s text-slate-500 mb-2">Semanas</p>
                                <p class="text-white font-medium">{{ props.plan.numero_semanas }}</p>
                            </div>
                            <div>
                                <p class="text-s text-slate-500 mb-2">Período</p>
                                <p class="text-white font-medium text-sm">{{ formatearFecha(props.plan.fecha_inicio) }}
                                    - {{ formatearFecha(props.plan.fecha_fin) }}</p>
                            </div>
                        </div>
                    </InfoCard>
                </div>

                <!-- Columna derecha -->
                <div class="lg:col-span-2">
                    <InfoCard title="Editar Sesión">
                        <form @submit.prevent="submitForm" class="space-y-6">

                            <!-- Seleccionar Semana -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-2">
                                    Semana <span class="text-red-400">*</span>
                                </label>
                                <select v-model.number="form.numero_semana"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 text-white cursor-pointer focus:outline-none focus:border-blue-500">
                                    <option v-for="i in props.plan.numero_semanas" :key="i" :value="i">
                                        Semana {{ i }}
                                    </option>
                                </select>
                                <p class="text-slate-400 text-sm mt-2">
                                    Sesiones en esta semana: {{ sesionesCountTotal }}/{{ props.plan.frecuencia_semanal
                                    }}
                                </p>
                            </div>

                            <!-- Nombre de la Sesión -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-2">
                                    Nombre de la Sesión <span class="text-red-400">*</span>
                                </label>
                                <input v-model="form.nombre" type="text" placeholder="Ej: Pecho y Tríceps"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-700 border border-slate-600 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500" />
                                <p v-if="form.errors.nombre" class="text-red-400 text-sm mt-2">{{ form.errors.nombre }}
                                </p>
                            </div>

                            <!-- Día de la Semana -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-2">
                                    Día de la Semana <span class="text-red-400">*</span>
                                </label>
                                <select v-model="form.dia_semana"
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
                                <p v-if="form.errors.dia_semana" class="text-red-400 text-sm mt-2">{{
                                    form.errors.dia_semana }}</p>
                                <p v-if="isDayAlreadyUsed" class="text-amber-400 text-sm mt-2">
                                    ⚠️ Ya existe una sesión para el {{ form.dia_semana }} en esta semana
                                </p>
                            </div>

                            <!-- Estado -->
                            <div v-if="!canAddSession" class="bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                                <p class="text-red-400 text-sm">
                                    Has alcanzado el máximo de {{ props.plan.frecuencia_semanal }} sesiones para la
                                    semana {{ form.numero_semana }}.
                                </p>
                            </div>

                            <!-- Botones -->
                            <div class="flex gap-3 pt-4">
                                <button type="submit" :disabled="form.processing || !canAddSession"
                                    class="flex-1 bg-blue-600 hover:bg-blue-500 disabled:bg-slate-600 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-lg transition">
                                    {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
                                </button>
                                <button type="button" @click="goBack"
                                    class="px-6 py-3 border border-slate-600 hover:border-slate-500 text-slate-300 hover:text-white font-semibold rounded-lg transition">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </InfoCard>
                </div>

            </div>

        </div>
    </AppLayout>
</template>

<style scoped>
.font-display {
    font-family: 'Oswald', sans-serif;
}
</style>

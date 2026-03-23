<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ChevronLeftIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    plan: {
        type: Object,
        required: true
    },
    sesion: {
        type: Object,
        required: true
    },
    ejercicios: {
        type: Array,
        required: true
    },
    nextOrder: {
        type: Number,
        default: 1
    }
});

const form = useForm({
    ejercicio_id: '',
    series: 3,
    repeticiones: 10,
    peso: 0,
    descanso_segundos: 60,
    orden: props.nextOrder,
});

const goBack = () => {
    window.history.back();
};

const handleSubmit = () => {
    form.post(route('ejercicios-sesion.store', [props.plan.id, props.sesion.id]), {
        onFinish: () => {
            form.reset();
        }
    });
};

const muscleOrder = {
    pecho: 1,
    espalda: 2,
    trapecio: 3,
    'hombros-frontales': 4,
    'hombros-traseros': 5,
    biceps: 6,
    triceps: 7,
    antebrazos: 8,
    abdomen: 9,
    oblicuos: 10,
    'baja-espalda': 11,
    gluteos: 12,
    cuadriceps: 13,
    isquiotibiales: 14,
    pantorrillas: 15,
};

const getSesionMuscleNames = () => {
    const groups = props.sesion?.muscle_groups || props.sesion?.muscleGroups || [];
    if (!Array.isArray(groups) || groups.length === 0) {
        return 'Sin grupos musculares';
    }
    return [...groups]
        .sort((a, b) => (muscleOrder[a?.slug] ?? 999) - (muscleOrder[b?.slug] ?? 999))
        .map(group => group.nombre)
        .join(', ');
};

// Agrupar ejercicios por grupo muscular (orden anatómico)
const ejerciciosPorGrupo = computed(() => {
    const grupos = {};

    props.ejercicios.forEach(ejercicio => {
        const grupoSlug = ejercicio.muscle_group?.slug || 'sin-grupo';
        const grupoNombre = ejercicio.muscle_group?.nombre || 'Sin grupo';

        if (!grupos[grupoSlug]) {
            grupos[grupoSlug] = {
                slug: grupoSlug,
                nombre: grupoNombre,
                ejercicios: []
            };
        }
        grupos[grupoSlug].ejercicios.push(ejercicio);
    });

    return Object.values(grupos)
        .sort((a, b) => {
            const orderA = muscleOrder[a.slug] ?? 999;
            const orderB = muscleOrder[b.slug] ?? 999;
            if (orderA !== orderB) return orderA - orderB;
            return a.nombre.localeCompare(b.nombre);
        })
        .map(grupo => ({
            ...grupo,
            ejercicios: [...grupo.ejercicios].sort((a, b) => a.nombre.localeCompare(b.nombre))
        }));
});

const selectedExercise = computed(() => {
    if (!form.ejercicio_id) return null;
    return props.ejercicios.find(e => Number(e.id) === Number(form.ejercicio_id)) || null;
});

const hasAvailableExercises = computed(() => props.ejercicios.length > 0);

const sessionMuscleGroups = computed(() => {
    const groups = props.sesion?.muscle_groups || props.sesion?.muscleGroups || [];
    return Array.isArray(groups) ? groups : [];
});

const missingSessionMuscleGroups = computed(() => {
    const availableGroupIds = new Set(
        props.ejercicios
            .map(e => e?.muscle_group?.id)
            .filter(Boolean)
            .map(id => Number(id))
    );

    return sessionMuscleGroups.value
        .filter(group => !availableGroupIds.has(Number(group.id)))
        .sort((a, b) => (muscleOrder[a?.slug] ?? 999) - (muscleOrder[b?.slug] ?? 999));
});
</script>

<template>
    <AppLayout title="Agregar Ejercicio a Sesión">
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <button @click="goBack" class="text-slate-400 hover:text-white transition-colors">
                    <ChevronLeftIcon class="w-6 h-6" />
                </button>
                <div>
                    <p class="text-m uppercase tracking-[0.3em] text-blue-300">{{ getSesionMuscleNames() }}</p>
                    <h2 class="text-4xl font-display text-white">Agregar Ejercicio · Semana {{
                        props.sesion.numero_semana }} - {{ props.sesion.dia_semana }}</h2>
                </div>
            </div>

            <!-- Formulario -->
            <form @submit.prevent="handleSubmit" class="max-w-4xl">
                <div class="bg-slate-900 rounded-lg p-8 space-y-6">

                    <!-- Seleccionar Ejercicio -->
                    <div>
                        <label for="ejercicio" class="block text-sm font-medium text-slate-300 mb-2">
                            Ejercicio <span class="text-red-400">*</span>
                        </label>
                        <select v-model="form.ejercicio_id" id="ejercicio"
                            class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            :class="{ 'border-red-500': form.errors.ejercicio_id }">
                            <option value="">-- Selecciona un ejercicio --</option>
                            <optgroup v-for="grupo in ejerciciosPorGrupo" :key="grupo.nombre" :label="grupo.nombre">
                                <option v-for="ejercicio in grupo.ejercicios" :key="ejercicio.id" :value="ejercicio.id">
                                    {{ ejercicio.nombre }}
                                </option>
                            </optgroup>
                        </select>
                        <p v-if="!hasAvailableExercises" class="text-amber-400 text-sm mt-2">
                            No hay ejercicios disponibles para los grupos musculares de esta sesión.
                        </p>
                        <p v-if="missingSessionMuscleGroups.length > 0" class="text-amber-300 text-sm mt-2">
                            Faltan ejercicios cargados para: {{missingSessionMuscleGroups.map(g => g.nombre).join(', ')
                            }}.
                        </p>
                        <span v-if="form.errors.ejercicio_id" class="text-red-400 text-sm mt-1">
                            {{ form.errors.ejercicio_id }}
                        </span>
                    </div>

                    <div v-if="selectedExercise" class="rounded-lg border border-slate-700 bg-slate-800/60 p-4">
                        <p class="text-xs uppercase tracking-[0.12em] text-slate-400 mb-3">Ejercicio seleccionado</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                            <div>
                                <p class="text-slate-400">Nombre</p>
                                <p class="text-white font-medium">{{ selectedExercise.nombre }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400">Grupo muscular</p>
                                <p class="text-white font-medium">{{ selectedExercise.muscle_group?.nombre || 'Sin grupo' }}</p>
                            </div>
                            <div>
                                <p class="text-slate-400">Tipo / Nivel</p>
                                <p class="text-white font-medium">{{ selectedExercise.tipo_ejercicio?.nombre || '—' }} ·
                                    {{ selectedExercise.nivel || '—' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Series -->
                        <div>
                            <label for="series" class="block text-sm font-medium text-slate-300 mb-2">Series</label>
                            <input v-model.number="form.series" type="number" id="series" min="1" max="10"
                                class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.series }" />
                            <span v-if="form.errors.series" class="text-red-400 text-sm mt-1">{{ form.errors.series
                                }}</span>
                        </div>

                        <!-- Repeticiones -->
                        <div>
                            <label for="repeticiones"
                                class="block text-sm font-medium text-slate-300 mb-2">Repeticiones</label>
                            <input v-model.number="form.repeticiones" type="number" id="repeticiones" min="1" max="100"
                                class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.repeticiones }" />
                            <span v-if="form.errors.repeticiones" class="text-red-400 text-sm mt-1">{{
                                form.errors.repeticiones }}</span>
                        </div>

                        <!-- Peso -->
                        <div>
                            <label for="peso" class="block text-sm font-medium text-slate-300 mb-2">Peso (kg)</label>
                            <input v-model.number="form.peso" type="number" id="peso" min="0" max="999.99" step="0.5"
                                class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.peso }" />
                            <span v-if="form.errors.peso" class="text-red-400 text-sm mt-1">{{ form.errors.peso
                                }}</span>
                        </div>

                        <!-- Descanso -->
                        <div>
                            <label for="descanso" class="block text-sm font-medium text-slate-300 mb-2">Descanso entre
                                series (segundos)</label>
                            <input v-model.number="form.descanso_segundos" type="number" id="descanso" min="0" max="300"
                                class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.descanso_segundos }" />
                            <span v-if="form.errors.descanso_segundos" class="text-red-400 text-sm mt-1">{{
                                form.errors.descanso_segundos }}</span>
                        </div>
                    </div>

                    <!-- Orden -->
                    <div>
                        <label for="orden" class="block text-sm font-medium text-slate-300 mb-2">
                            Orden de ejecución
                        </label>
                        <input v-model.number="form.orden" type="number" id="orden" min="1"
                            class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            :class="{ 'border-red-500': form.errors.orden }" />
                        <p class="text-slate-400 text-xs mt-2">Sugerido: {{ props.nextOrder }}</p>
                        <span v-if="form.errors.orden" class="text-red-400 text-sm mt-1">
                            {{ form.errors.orden }}
                        </span>
                    </div>

                </div>

                <!-- Botones -->
                <div class="flex gap-4 mt-8">
                    <button type="submit" :disabled="form.processing || !hasAvailableExercises"
                        class="px-6 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-700 transition-colors font-medium disabled:opacity-50">
                        {{ form.processing ? 'Guardando...' : 'Agregar Ejercicio' }}
                    </button>
                    <button type="button" @click="goBack"
                        class="px-6 py-2 rounded bg-slate-700 text-white hover:bg-slate-600 transition-colors font-medium">
                        Cancelar
                    </button>
                </div>
            </form>

        </div>
    </AppLayout>
</template>

<style scoped>
.font-display {
    font-family: 'Oswald', sans-serif;
}
</style>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmModal from '@/Components/Feedback/ConfirmModal.vue';
import { ChevronLeftIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

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
    }
});

const showConfirm = ref(false);
const pendingEjercicioId = ref(null);

const deleteForm = useForm({});

const openDeleteModal = (ejercicioId) => {
    pendingEjercicioId.value = ejercicioId;
    showConfirm.value = true;
};

const closeDeleteModal = () => {
    showConfirm.value = false;
    pendingEjercicioId.value = null;
};

const confirmDelete = () => {
    deleteForm.delete(
        route('ejercicios-sesion.destroy', [props.plan.id, props.sesion.id, pendingEjercicioId.value]),
        { onFinish: closeDeleteModal }
    );
};

const goBack = () => {
    window.history.back();
};

// Agrupar ejercicios por grupo muscular
const ejerciciosPorGrupo = computed(() => {
    const grupos = {};

    props.ejercicios.forEach(ejercicio => {
        const grupoNombre = ejercicio.ejercicio.muscle_group?.nombre || 'Sin grupo';
        const grupoSlug = ejercicio.ejercicio.muscle_group?.slug || 'sin-grupo';
        if (!grupos[grupoSlug]) {
            grupos[grupoSlug] = {
                nombre: grupoNombre,
                slug: grupoSlug,
                ejercicios: []
            };
        }
        grupos[grupoSlug].ejercicios.push(ejercicio);
    });

    // Ordenar grupos por orden predefinido
    const orden = ['pecho', 'espalda', 'trapecio', 'hombros', 'brazos', 'antebrazos',
        'abdominales', 'oblicuos', 'lumbares', 'gluteos', 'cuadriceps',
        'femoral', 'aductores', 'pantorrillas', 'sin-grupo'];

    return Object.values(grupos).sort((a, b) => {
        const indexA = orden.indexOf(a.slug);
        const indexB = orden.indexOf(b.slug);
        return (indexA === -1 ? 999 : indexA) - (indexB === -1 ? 999 : indexB);
    });
});

// Colores para cada grupo muscular
const muscleColors = {
    'pecho': '#ef4444',
    'espalda': '#f97316',
    'trapecio': '#f59e0b',
    'hombros': '#eab308',
    'brazos': '#84cc16',
    'antebrazos': '#22c55e',
    'abdominales': '#10b981',
    'oblicuos': '#14b8a6',
    'lumbares': '#06b6d4',
    'gluteos': '#0ea5e9',
    'cuadriceps': '#3b82f6',
    'femoral': '#6366f1',
    'aductores': '#8b5cf6',
    'pantorrillas': '#a855f7',
    'sin-grupo': '#64748b'
};

const getGrupoColor = (slug) => {
    return muscleColors[slug] || '#64748b';
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

const totalEjercicios = computed(() => props.ejercicios.length || 0);

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
</script>

<template>
    <AppLayout title="Ejercicios de Sesión">
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <button @click="goBack" class="text-slate-400 hover:text-white transition-colors">
                        <ChevronLeftIcon class="w-6 h-6" />
                    </button>
                    <div>
                        <p class="text-m uppercase tracking-[0.3em] text-blue-300">{{ getSesionMuscleNames() }}</p>
                        <h2 class="text-4xl font-display text-white">Ejercicios · Semana {{ props.sesion.numero_semana
                        }} - {{ props.sesion.dia_semana }}</h2>
                    </div>
                </div>
                <a :href="route('ejercicios-sesion.create', [props.plan.id, props.sesion.id])"
                    class="px-6 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-700 transition-colors font-medium">
                    + Agregar Ejercicio
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">
                <div class="bg-slate-900 rounded-lg border border-slate-800 p-4">
                    <p class="text-xs uppercase tracking-[0.1em] text-slate-400">Total ejercicios</p>
                    <p class="text-2xl text-white font-semibold">{{ totalEjercicios }}</p>
                </div>
                <div class="bg-slate-900 rounded-lg border border-slate-800 p-4">
                    <p class="text-xs uppercase tracking-[0.1em] text-slate-400">Semana</p>
                    <p class="text-2xl text-white font-semibold">{{ props.sesion.numero_semana }}</p>
                </div>
                <div class="bg-slate-900 rounded-lg border border-slate-800 p-4">
                    <p class="text-xs uppercase tracking-[0.1em] text-slate-400">Día</p>
                    <p class="text-2xl text-white font-semibold">{{ props.sesion.dia_semana }}</p>
                </div>
            </div>

            <!-- Tabla de Ejercicios -->
            <div v-if="ejercicios.length === 0" class="bg-slate-900 rounded-lg p-8 text-center text-slate-400">
                No hay ejercicios agregados a esta sesión
            </div>

            <!-- Ejercicios agrupados por grupo muscular -->
            <div v-else class="space-y-6">
                <div v-for="grupo in ejerciciosPorGrupo" :key="grupo.slug"
                    class="bg-slate-900 rounded-lg overflow-hidden">
                    <!-- Header del grupo -->
                    <div class="px-6 py-3 border-b border-slate-700 flex items-center gap-3"
                        :style="{ backgroundColor: getGrupoColor(grupo.slug) + '33' }">
                        <div class="w-3 h-3 rounded-full" :style="{ backgroundColor: getGrupoColor(grupo.slug) }"></div>
                        <h3 class="text-lg font-semibold text-white capitalize">{{ grupo.nombre }}</h3>
                        <span class="text-sm text-slate-400">({{ grupo.ejercicios.length }} ejercicio{{
                            grupo.ejercicios.length !== 1 ? 's' : '' }})</span>
                    </div>

                    <!-- Tabla de ejercicios del grupo -->
                    <table class="w-full">
                        <thead class="bg-slate-800 border-b border-slate-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-300">Ejercicio</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-300">Series</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-300">Repeticiones</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-300">Peso (kg)</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-300">Descanso (s)</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-300">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            <tr v-for="ejercicio in grupo.ejercicios" :key="ejercicio.id"
                                class="hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 text-slate-100">{{ ejercicio.ejercicio.nombre }}</td>
                                <td class="px-6 py-4 text-slate-100">{{ ejercicio.series }}</td>
                                <td class="px-6 py-4 text-slate-100">{{ ejercicio.repeticiones }}</td>
                                <td class="px-6 py-4 text-slate-100">{{ ejercicio.peso }}</td>
                                <td class="px-6 py-4 text-slate-100">{{ ejercicio.descanso_segundos }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a :href="route('ejercicios-sesion.edit', [props.plan.id, props.sesion.id, ejercicio.id])"
                                        class="p-2 text-blue-400 hover:bg-blue-950/30 rounded transition-colors">
                                        <PencilIcon class="w-4 h-4" />
                                    </a>
                                    <button @click="openDeleteModal(ejercicio.id)"
                                        class="p-2 text-red-400 hover:bg-red-950/30 rounded transition-colors">
                                        <TrashIcon class="w-4 h-4" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Confirm Delete Modal -->
        <ConfirmModal v-bind="{ show: showConfirm, loading: deleteForm.processing }" title="Eliminar Ejercicio"
            message="¿Estás seguro de que deseas eliminar este ejercicio de la sesión? Esta acción no se puede deshacer."
            confirmText="Eliminar" @confirm="confirmDelete" @cancel="closeDeleteModal" />
    </AppLayout>
</template>

<style scoped>
.font-display {
    font-family: 'Oswald', sans-serif;
}
</style>

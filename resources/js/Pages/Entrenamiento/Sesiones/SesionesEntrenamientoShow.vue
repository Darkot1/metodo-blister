<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ConfirmModal from '@/Components/Feedback/ConfirmModal.vue';
import { ChevronLeftIcon, PencilIcon, TrashIcon, EyeIcon, PlusIcon } from '@heroicons/vue/24/outline';
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
    }
});

const showConfirm = ref(false);
const deleteForm = useForm({});

const openDeleteModal = () => {
    showConfirm.value = true;
};

const closeDeleteModal = () => {
    showConfirm.value = false;
};

const confirmDelete = () => {
    deleteForm.delete(
        route('sesiones-entrenamiento.destroy', [props.plan.id, props.sesion.id]),
        { onFinish: closeDeleteModal }
    );
};

const goBack = () => {
    window.history.back();
};

const getSessionMuscleNames = (sesion) => {
    const groups = getSortedSessionMuscleGroups(sesion);
    if (!Array.isArray(groups) || groups.length === 0) {
        return 'Sin grupos musculares';
    }
    return groups.map(group => group.nombre).join(', ');
};

const getSessionMuscleGroups = (sesion) => {
    const groups = sesion?.muscle_groups || sesion?.muscleGroups || [];
    return Array.isArray(groups) ? groups : [];
};

const muscleColors = {
    pecho: '#ef4444',
    espalda: '#f97316',
    trapecio: '#eab308',
    'hombros-traseros': '#fbbf24',
    'hombros-frontales': '#fcd34d',
    biceps: '#22c55e',
    triceps: '#10b981',
    antebrazos: '#14b8a6',
    abdomen: '#8b5cf6',
    oblicuos: '#a78bfa',
    'baja-espalda': '#f472b6',
    gluteos: '#0ea5e9',
    cuadriceps: '#06b6d4',
    isquiotibiales: '#0284c7',
    pantorrillas: '#1e40af'
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

const getSortedSessionMuscleGroups = (sesion) => {
    return [...getSessionMuscleGroups(sesion)].sort((a, b) => {
        const orderA = muscleOrder[a?.slug] ?? 999;
        const orderB = muscleOrder[b?.slug] ?? 999;
        if (orderA !== orderB) return orderA - orderB;
        return (a?.nombre || '').localeCompare(b?.nombre || '', 'es');
    });
};

const getChipStyle = (group) => {
    const color = muscleColors[group?.slug] || '#64748b';
    return {
        backgroundColor: `${color}33`,
        borderColor: `${color}80`,
        color,
    };
};

const totalEjerciciosSesion = computed(() => {
    const ejercicios = props.sesion?.ejercicios;
    return Array.isArray(ejercicios) ? ejercicios.length : 0;
});
</script>

<template>
    <AppLayout title="Detalles de Sesión">
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <button @click="goBack" class="text-slate-400 hover:text-white transition-colors">
                        <ChevronLeftIcon class="w-6 h-6" />
                    </button>
                    <div>
                        <p class="text-m uppercase tracking-[0.3em] text-blue-300">{{
                            getSessionMuscleNames(props.sesion) }}</p>
                        <h2 class="text-4xl font-display text-white">Semana {{ props.sesion.numero_semana }} - {{
                            props.sesion.dia_semana }}</h2>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a :href="route('sesiones-entrenamiento.edit', [props.plan.id, props.sesion.id])"
                        class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                        <PencilIcon class="w-4 h-4" />
                        Editar
                    </a>
                    <button @click="openDeleteModal"
                        class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition-colors font-medium flex items-center gap-2">
                        <TrashIcon class="w-4 h-4" />
                        Eliminar
                    </button>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">

                <!-- Información de la Sesión -->
                <div class="lg:col-span-1">
                    <div class="bg-slate-900 rounded-lg p-6 space-y-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.1em] text-slate-400 mb-1">Plan</p>
                            <p class="text-lg text-white font-medium">{{ props.plan.nombre }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.1em] text-slate-400 mb-1">Alumno</p>
                            <p class="text-lg text-white font-medium">{{ props.plan.alumno.nombres }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.1em] text-slate-400 mb-1">Día</p>
                            <p class="text-lg text-white font-medium">{{ props.sesion.dia_semana }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.1em] text-slate-400 mb-1">Semana</p>
                            <p class="text-lg text-white font-medium">{{ props.sesion.numero_semana }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.1em] text-slate-400 mb-1">Grupos musculares</p>
                            <div v-if="getSessionMuscleGroups(props.sesion).length > 0" class="flex flex-wrap gap-2">
                                <span v-for="group in getSortedSessionMuscleGroups(props.sesion)" :key="group.id"
                                    class="px-2 py-0.5 rounded-full text-xs border" :style="getChipStyle(group)">
                                    {{ group.nombre }}
                                </span>
                            </div>
                            <p v-else class="text-lg text-white font-medium">{{ getSessionMuscleNames(props.sesion) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Ejercicios de la Sesión -->
                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-display text-white">Ejercicios ({{ totalEjerciciosSesion }})</h3>
                        <a :href="route('ejercicios-sesion.index', [props.plan.id, props.sesion.id])"
                            class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition-colors font-medium text-sm flex items-center gap-2">
                            <component :is="totalEjerciciosSesion > 0 ? EyeIcon : PlusIcon" class="w-4 h-4" />
                            {{ totalEjerciciosSesion > 0 ? 'Gestionar ejercicios' : 'Agregar ejercicios' }}
                        </a>
                    </div>

                    <!-- Tabla de Ejercicios -->
                    <div class="bg-slate-900 rounded-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-slate-800 border-b border-slate-700">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Ejercicio</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Series</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Reps</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Peso (kg)</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Descanso (s)
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">
                                <tr v-if="props.sesion.ejercicios.length === 0"
                                    class="hover:bg-slate-800/50 transition-colors">
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                        No hay ejercicios agregados
                                    </td>
                                </tr>
                                <tr v-for="ejercicio in props.sesion.ejercicios" :key="ejercicio.id"
                                    class="hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 text-slate-100">{{ ejercicio.ejercicio.nombre }}</td>
                                    <td class="px-6 py-4 text-slate-100">{{ ejercicio.series }}</td>
                                    <td class="px-6 py-4 text-slate-100">{{ ejercicio.repeticiones }}</td>
                                    <td class="px-6 py-4 text-slate-100">{{ ejercicio.peso }}</td>
                                    <td class="px-6 py-4 text-slate-100">{{ ejercicio.descanso_segundos }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

        <!-- Confirm Delete Modal -->
        <ConfirmModal v-bind="{ show: showConfirm, loading: deleteForm.processing }" title="Eliminar Sesión"
            message="¿Estás seguro de que deseas eliminar esta sesión? También se eliminarán todos los ejercicios asociados a ella."
            confirmText="Eliminar" @confirm="confirmDelete" @cancel="closeDeleteModal" />
    </AppLayout>
</template>

<style scoped>
.font-display {
    font-family: 'Oswald', sans-serif;
}
</style>

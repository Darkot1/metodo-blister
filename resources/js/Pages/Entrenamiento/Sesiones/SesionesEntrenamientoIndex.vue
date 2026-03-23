<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InfoCard from '@/Components/InfoCard.vue';
import ConfirmModal from '@/Components/Feedback/ConfirmModal.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ChevronLeftIcon, PlusIcon, PencilIcon, TrashIcon, EyeIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';
import { usePlan } from '@/Composables/usePlan';

const { formatearFecha } = usePlan();

const props = defineProps({
    plan: {
        type: Object,
        required: true
    }
})

const deleteForm = useForm({});
const showConfirm = ref(false);
const pendingSessionId = ref(null);

const goBack = () => {
    window.history.back();
};

const openDeleteModal = (sesionId) => {
    pendingSessionId.value = sesionId;
    showConfirm.value = true;
};

const closeDeleteModal = () => {
    showConfirm.value = false;
    pendingSessionId.value = null;
};

const confirmDelete = () => {
    if (!pendingSessionId.value) {
        return;
    }
    deleteForm.delete(route('sesiones-entrenamiento.destroy', {
        plan: props.plan.id,
        sesion: pendingSessionId.value,
    }), {
        onFinish: () => {
            closeDeleteModal();
        }
    });
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
</script>

<template>
    <AppLayout title="Sesiones del Plan">
        <ConfirmModal :show="showConfirm" title="Eliminar sesion"
            message="Estas seguro de eliminar esta sesion? Esta accion no se puede deshacer." confirm-text="Eliminar"
            :loading="deleteForm.processing" @confirm="confirmDelete" @cancel="closeDeleteModal" />
        <div class="-m-8 min-h-full p-8">
            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <button @click="goBack" class="text-slate-400 hover:text-white transition-colors">
                    <ChevronLeftIcon class="w-6 h-6" />
                </button>
                <div class="flex items-center gap-4 flex-1">
                    <div
                        class="h-16 w-16 rounded-full bg-blue-600/30 flex items-center justify-center text-xl font-semibold text-blue-300">
                        {{ props.plan.nombre.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <p class="text-m uppercase tracking-[0.3em] text-blue-300">Plan</p>
                        <h2 class="text-4xl font-display text-white">Sesiones - {{ props.plan.nombre }}</h2>
                    </div>
                </div>
                <Link :href="route('sesiones-entrenamiento.create', props.plan.id)"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
                    <PlusIcon class="w-4 h-4" />
                    Agregar sesiones
                </Link>
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
                    <InfoCard title="Sesiones por Semana">
                        <div v-if="props.plan.sesiones.length === 0" class="text-slate-400 py-8 text-center">
                            <p>No hay sesiones creadas aún</p>
                            <p class="text-sm mt-2">Agrega sesiones para comenzar</p>
                        </div>

                        <div v-else v-for="semana in props.plan.numero_semanas" :key="semana" class="mb-6">
                            <h3 class="text-white font-semibold mb-2">Semana {{ semana }}</h3>
                            <p class="text-slate-400 text-sm mb-3">
                                Sesiones: {{props.plan.sesiones.filter(s => s.numero_semana === semana).length}}/{{
                                    props.plan.frecuencia_semanal }}
                            </p>

                            <ul v-if="props.plan.sesiones.some(s => s.numero_semana === semana)" class="space-y-2">
                                <li v-for="sesion in props.plan.sesiones.filter(s => s.numero_semana === semana)"
                                    :key="sesion.id" class="flex items-start justify-between gap-3">
                                    <div class="text-slate-300 flex flex-col gap-2">
                                        <div class="flex items-center gap-2">
                                            <span class="text-blue-400">•</span>
                                            <span class="text-slate-200 font-medium">{{
                                                sesion.dia_semana
                                                }}</span>
                                        </div>
                                        <div v-if="getSessionMuscleGroups(sesion).length > 0"
                                            class="flex flex-wrap gap-1.5">
                                            <span v-for="group in getSortedSessionMuscleGroups(sesion)" :key="group.id"
                                                class="px-2 py-0.5 rounded-full text-xs border"
                                                :style="getChipStyle(group)">
                                                {{ group.nombre }}
                                            </span>
                                        </div>
                                        <div v-else class="text-sm text-slate-400">
                                            {{ getSessionMuscleNames(sesion) }}
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <Link
                                            :href="route('sesiones-entrenamiento.show', { plan: props.plan.id, sesion: sesion.id })"
                                            class="text-blue-400 hover:text-blue-300 transition-colors">
                                            <EyeIcon class="w-4 h-4" />
                                        </Link>
                                        <Link
                                            :href="route('sesiones-entrenamiento.edit', { plan: props.plan.id, sesion: sesion.id })"
                                            class="text-slate-300 hover:text-white transition-colors">
                                            <PencilIcon class="w-4 h-4" />
                                        </Link>
                                        <button type="button" @click="openDeleteModal(sesion.id)"
                                            class="text-red-300 hover:text-red-200 transition-colors"
                                            :disabled="deleteForm.processing">
                                            <TrashIcon class="w-4 h-4" />
                                        </button>
                                    </div>
                                </li>
                            </ul>
                            <p v-else class="text-slate-500 text-sm italic">
                                Sin sesiones en esta semana
                            </p>
                        </div>
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

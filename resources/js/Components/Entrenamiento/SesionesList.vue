<script setup>
import InfoCard from '@/Components/InfoCard.vue';

const props = defineProps({
    plan: {
        type: Object,
        required: true
    }
})

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
    <InfoCard title="Sesiones Creadas">
        <div class="space-y-3">
            <div v-if="props.plan.sesiones.length === 0" class="text-slate-400 text-sm">
                Sin sesiones aún
            </div>
            <div v-else v-for="semana in props.plan.numero_semanas" :key="semana" class="mb-4">
                <h4 class="text-white font-semibold text-sm mb-2">Semana {{ semana }}</h4>
                <ul class="space-y-1">
                    <li v-for="sesion in props.plan.sesiones.filter(s => s.numero_semana === semana)" :key="sesion.id"
                        class="text-slate-300 text-sm space-y-1.5">
                        <div class="text-slate-200 font-medium">{{ sesion.dia_semana }}</div>
                        <div v-if="getSessionMuscleGroups(sesion).length > 0" class="flex flex-wrap gap-1.5">
                            <span v-for="group in getSortedSessionMuscleGroups(sesion)" :key="group.id"
                                class="px-2 py-0.5 rounded-full text-xs border" :style="getChipStyle(group)">
                                {{ group.nombre }}
                            </span>
                        </div>
                        <div v-else class="text-slate-400 text-xs">
                            {{ getSessionMuscleNames(sesion) }}
                        </div>
                    </li>
                </ul>
                <p v-if="!props.plan.sesiones.some(s => s.numero_semana === semana)"
                    class="text-slate-500 text-xs italic">
                    Sin sesiones
                </p>
            </div>
        </div>
    </InfoCard>
</template>

<script setup>
import InfoCard from '@/Components/InfoCard.vue';
import { usePlan } from '@/Composables/usePlan';

const { formatearFecha } = usePlan();

const props = defineProps({
    plan: {
        type: Object,
        required: true
    }
})
</script>

<template>
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
</template>

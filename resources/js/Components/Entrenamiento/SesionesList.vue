<script setup>
import InfoCard from '@/Components/InfoCard.vue';

const props = defineProps({
    plan: {
        type: Object,
        required: true
    }
})
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
                        class="text-slate-300 text-sm">
                        {{ sesion.nombre }} - {{ sesion.dia_semana }}
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

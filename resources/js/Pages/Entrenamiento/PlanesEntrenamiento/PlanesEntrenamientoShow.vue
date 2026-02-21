<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InfoCard from '@/Components/InfoCard.vue';
import EstadoBadge from '@/Components/EstadoBadge.vue';
import ConfirmModal from '@/Components/Feedback/ConfirmModal.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { ChevronLeftIcon, TrashIcon, PencilIcon, PlusIcon } from '@heroicons/vue/24/outline';
import { usePlan } from '@/Composables/usePlan';

const { getFrequencia, formatearFecha, calcularDuracion } = usePlan();

const props = defineProps({
    plan: {
        type: Object,
        required: true
    }
})

const semanas = computed(() => {
    const result = [];
    for (let i = 1; i <= props.plan.numero_semanas; i++) {
        result.push({
            numero: i,
            sesiones: props.plan.sesiones.filter(s => s.numero_semana === i)
        });
    }
    return result;
});

const deleteForm = useForm({});
const showConfirm = ref(false);

const destroyPlan = () => {
    showConfirm.value = true;
};

const closeConfirm = () => {
    showConfirm.value = false;
};

const confirmDelete = () => {
    deleteForm.delete(route('planes-entrenamiento.destroy', props.plan.id), {
        onFinish: () => {
            closeConfirm();
        }
    });
};

const calcularDuracionPlan = () => {
    return calcularDuracion(props.plan.fecha_inicio, props.plan.fecha_fin);
};
</script>


<template>
    <AppLayout title="Detalle Plan de Entrenamiento">
        <ConfirmModal :show="showConfirm" title="Eliminar plan"
            message="Estas seguro de eliminar este plan? Esta accion no se puede deshacer." confirm-text="Eliminar"
            :loading="deleteForm.processing" @confirm="confirmDelete" @cancel="closeConfirm" />
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <Link :href="route('planes-entrenamiento.index')"
                    class="text-slate-400 hover:text-white transition-colors">
                    <ChevronLeftIcon class="w-6 h-6" />
                </Link>
                <div class="flex items-center gap-4 flex-1">
                    <div
                        class="h-20 w-20 rounded-full bg-blue-600/30 flex items-center justify-center text-2xl font-semibold text-blue-300">
                        {{ props.plan.nombre.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <p class="text-m uppercase tracking-[0.3em] text-blue-300">Plan</p>
                        <h2 class="text-4xl font-display text-white">{{ props.plan.nombre }}</h2>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" @click="destroyPlan" :disabled="deleteForm.processing"
                        class="border border-red-500/40 text-red-200 px-6 py-3 rounded-xl font-semibold hover:bg-red-500/10 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                        <TrashIcon class="w-5 h-5" />
                        Eliminar
                    </button>
                    <Link :href="route('planes-entrenamiento.edit', props.plan.id)"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30 flex items-center gap-2">
                        <PencilIcon class="w-5 h-5" />
                        Editar Plan
                    </Link>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">

                <!-- Columna izquierda -->
                <div class="space-y-6">

                    <!-- Estado -->
                    <div class="bg-white/5 border border-white/10 rounded-xl p-6 space-y-4">
                        <EstadoBadge :estado="props.plan.estado" />
                    </div>

                    <!-- Información del Plan -->
                    <InfoCard title="Información del Plan">
                        <div class="space-y-4">
                            <div>
                                <p class="text-s text-slate-500 mb-2">Alumno</p>
                                <p class="text-white font-medium text-lg">{{ props.plan.alumno?.nombres }} {{
                                    props.plan.alumno?.apellidos }}</p>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-s text-slate-500 mb-2">Frecuencia</p>
                                    <p class="text-white font-medium">{{ getFrequencia(props.plan.frecuencia_semanal) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-s text-slate-500 mb-2">Duración</p>
                                    <p class="text-white font-medium">{{ calcularDuracionPlan() }}</p>
                                </div>
                            </div>
                        </div>
                    </InfoCard>

                    <!-- Fechas -->
                    <InfoCard title="Fechas">
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-s text-slate-500 mb-2">Fecha de inicio</p>
                                <p class="text-white font-medium">{{ formatearFecha(props.plan.fecha_inicio) }}</p>
                            </div>
                            <div>
                                <p class="text-s text-slate-500 mb-2">Fecha de fin</p>
                                <p class="text-white font-medium">{{ formatearFecha(props.plan.fecha_fin) }}</p>
                            </div>
                        </div>
                    </InfoCard>

                </div>

                <!-- Columna derecha -->
                <div class="space-y-6">

                    <!-- Objetivo -->
                    <InfoCard v-if="props.plan.objetivo" title="Objetivo">
                        <p class="text-slate-300 whitespace-pre-wrap leading-relaxed">{{ props.plan.objetivo }}</p>
                    </InfoCard>

                    <InfoCard title="Sesiones por Semana">
                        <div v-if="props.plan.sesiones.length === 0" class="text-slate-400 py-8 text-center">
                            <p>No hay sesiones creadas aún</p>
                            <p class="text-sm mt-2">Haz clic en "Agregar Sesiones" para comenzar</p>
                        </div>

                        <div v-else v-for="semana in semanas" :key="semana.numero" class="mb-6">
                            <h3 class="text-white font-semibold mb-2">Semana {{ semana.numero }}</h3>
                            <p class="text-slate-400 text-sm mb-3">
                                Sesiones: {{ semana.sesiones.length }}/{{ props.plan.frecuencia_semanal }}
                            </p>

                            <ul v-if="semana.sesiones.length > 0" class="space-y-1">
                                <li v-for="sesion in semana.sesiones" :key="sesion.id"
                                    class="text-slate-300 flex items-center gap-2">
                                    <span class="text-blue-400">•</span>
                                    {{ sesion.nombre }} - <span class="text-slate-500">{{ sesion.dia_semana }}</span>
                                </li>
                            </ul>
                            <p v-else class="text-slate-500 text-sm italic">
                                Sin sesiones en esta semana
                            </p>
                        </div>
                    </InfoCard>

                    <!-- Información del Sistema -->
                    <InfoCard title="Información del Sistema">
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-slate-500">ID del Plan</p>
                                <p class="text-white font-mono text-xs">{{ props.plan.id }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500">Creado</p>
                                <p class="text-white">{{ formatearFecha(props.plan.created_at) }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500">Última actualización</p>
                                <p class="text-white">{{ formatearFecha(props.plan.updated_at) }}</p>
                            </div>
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

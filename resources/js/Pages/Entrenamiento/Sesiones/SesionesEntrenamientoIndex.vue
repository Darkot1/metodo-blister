<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InfoCard from '@/Components/InfoCard.vue';
import ConfirmModal from '@/Components/Feedback/ConfirmModal.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ChevronLeftIcon, PlusIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';
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
                                    :key="sesion.id" class="flex items-center justify-between gap-3">
                                    <div class="text-slate-300 flex items-center gap-2">
                                        <span class="text-blue-400">•</span>
                                        {{ sesion.nombre }} - <span class="text-slate-500">{{ sesion.dia_semana
                                            }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
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

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import EstadoBadge from '@/Components/EstadoBadge.vue';
import InfoCard from '@/Components/InfoCard.vue';
import ConfirmModal from '@/Components/Feedback/ConfirmModal.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ChevronLeftIcon, PlayIcon, TrashIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    ejercicio: {
        type: Object,
        required: true
    }
})

const deleteForm = useForm({});
const showConfirm = ref(false);

const destroyEjercicio = () => {
    showConfirm.value = true;
};

const closeConfirm = () => {
    showConfirm.value = false;
};

const confirmDelete = () => {
    deleteForm.delete(route('ejercicios.destroy', props.ejercicio.id), {
        onFinish: () => {
            closeConfirm();
        }
    });
};

const getNivelColor = (nivel) => {
    const colores = {
        'principiante': 'bg-green-500/20 text-green-200 border-green-500/30',
        'intermedio': 'bg-yellow-500/20 text-yellow-200 border-yellow-500/30',
        'avanzado': 'bg-red-500/20 text-red-200 border-red-500/30'
    };
    return colores[nivel] || 'bg-slate-500/20 text-slate-200 border-slate-500/30';
};

const getNivelLabel = (nivel) => {
    const labels = {
        'principiante': 'Principiante',
        'intermedio': 'Intermedio',
        'avanzado': 'Avanzado'
    };
    return labels[nivel] || nivel;
};

const formatearFecha = (fecha) => {
    if (!fecha) return '—';
    return new Date(fecha).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>

<template>
    <AppLayout title="Detalle Ejercicio">
        <ConfirmModal :show="showConfirm" title="Eliminar ejercicio"
            message="Estas seguro de eliminar este ejercicio? Esta accion no se puede deshacer." confirm-text="Eliminar"
            :loading="deleteForm.processing" @confirm="confirmDelete" @cancel="closeConfirm" />
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <Link :href="route('ejercicios.index')" class="text-slate-400 hover:text-white transition-colors">
                    <ChevronLeftIcon class="w-6 h-6" />
                </Link>
                <div class="flex items-center gap-4 flex-1">
                    <div
                        class="h-20 w-20 rounded-full bg-blue-600/30 flex items-center justify-center text-2xl font-semibold text-blue-300">
                        {{ ejercicio.nombre.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <p class="text-m uppercase tracking-[0.3em] text-blue-300">Ejercicio</p>
                        <h2 class="text-4xl font-display text-white">{{ ejercicio.nombre }}</h2>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" @click="destroyEjercicio" :disabled="deleteForm.processing"
                        class="border border-red-500/40 text-red-200 px-6 py-3 rounded-xl font-semibold hover:bg-red-500/10 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Eliminar
                    </button>
                    <Link :href="route('ejercicios.edit', ejercicio.id)"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
                        Editar Ejercicio
                    </Link>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">

                <!-- Columna izquierda -->
                <div class="space-y-6">

                    <!-- Estado y Nivel -->
                    <div class="bg-white/5 border border-white/10 rounded-xl p-6 space-y-4">
                        <div class="flex gap-3">
                            <EstadoBadge :estado="ejercicio.estado" />
                            <div
                                :class="['px-4 py-2 rounded-lg border font-semibold text-sm', getNivelColor(ejercicio.nivel)]">
                                {{ getNivelLabel(ejercicio.nivel) }}
                            </div>
                        </div>
                    </div>

                    <!-- Información del Ejercicio -->
                    <InfoCard title="Información">
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-s text-slate-500 mb-2">Tipo de Ejercicio</p>
                                <p class="text-white font-medium text-lg">{{ ejercicio.tipo_ejercicio?.nombre || '—' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-s text-slate-500 mb-2">Grupo Muscular</p>
                                <p class="text-white font-medium text-lg capitalize">{{ ejercicio.grupo_muscular || '—'
                                }}</p>
                            </div>
                        </div>
                    </InfoCard>

                    <!-- Video -->
                    <div v-if="ejercicio.video_url" class="bg-white/5 border border-white/10 rounded-xl p-6">
                        <p class="text-s text-slate-500 font-semibold uppercase tracking-wider mb-4">Video Tutorial</p>
                        <a :href="ejercicio.video_url" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-3 w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white py-3 px-6 rounded-xl font-semibold transition shadow-lg shadow-blue-600/30">
                            <PlayIcon class="w-5 h-5" />
                            Ver Video
                        </a>
                    </div>

                </div>

                <!-- Columna derecha -->
                <div class="space-y-6">

                    <!-- Descripción -->
                    <InfoCard v-if="ejercicio.descripcion" title="Descripción">
                        <p class="text-slate-300 whitespace-pre-wrap leading-relaxed">{{ ejercicio.descripcion }}</p>
                    </InfoCard>

                    <!-- Información del Sistema -->
                    <InfoCard title="Información del Sistema">
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-slate-500">ID del Ejercicio</p>
                                <p class="text-white font-mono text-xs">{{ ejercicio.id }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500">Creado</p>
                                <p class="text-white">{{ formatearFecha(ejercicio.created_at) }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500">Última actualización</p>
                                <p class="text-white">{{ formatearFecha(ejercicio.updated_at) }}</p>
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

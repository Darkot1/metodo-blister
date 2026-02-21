<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InfoCard from '@/Components/InfoCard.vue';
import ConfirmModal from '@/Components/Feedback/ConfirmModal.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ChevronLeftIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    tipoEjercicio: {
        type: Object,
        required: true
    }
})

const deleteForm = useForm({});
const showConfirm = ref(false);

const destroyTipo = () => {
    showConfirm.value = true;
};

const closeConfirm = () => {
    showConfirm.value = false;
};

const confirmDelete = () => deleteForm.delete(route('tipo-ejercicios.destroy', props.tipoEjercicio.id), { onFinish: closeConfirm });

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
    <AppLayout title="Detalle Tipo de Ejercicio">
        <ConfirmModal :show="showConfirm" title="Eliminar tipo de ejercicio"
            message="Estas seguro de eliminar este tipo de ejercicio? Esta accion no se puede deshacer."
            confirm-text="Eliminar" :loading="deleteForm.processing" @confirm="confirmDelete" @cancel="closeConfirm" />
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <Link :href="route('tipo-ejercicios.index')" class="text-slate-400 hover:text-white transition-colors">
                    <ChevronLeftIcon class="w-6 h-6" />
                </Link>
                <div class="flex items-center gap-4 flex-1">
                    <div
                        class="h-20 w-20 rounded-full bg-blue-600/30 flex items-center justify-center text-2xl font-semibold text-blue-300">
                        {{ tipoEjercicio.nombre.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <p class="text-m uppercase tracking-[0.3em] text-blue-300">Tipo de Ejercicio</p>
                        <h2 class="text-4xl font-display text-white">{{ tipoEjercicio.nombre }}</h2>
                        <span :class="[
                            'inline-flex px-3 py-1 rounded-full text-xs font-semibold mt-2',
                            tipoEjercicio.estado === 'activo'
                                ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30'
                                : 'bg-gray-500/20 text-gray-300 border border-gray-500/30'
                        ]">
                            {{ tipoEjercicio.estado === 'activo' ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" @click="destroyTipo" :disabled="deleteForm.processing"
                        class="border border-red-500/40 text-red-200 px-6 py-3 rounded-xl font-semibold hover:bg-red-500/10 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Eliminar
                    </button>
                    <Link :href="route('tipo-ejercicios.edit', tipoEjercicio.id)"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
                        Editar Tipo
                    </Link>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">

                <!-- Información Principal -->
                <InfoCard title="Información General">
                    <div class="space-y-4">
                        <div>
                            <p class="text-s text-slate-500 mb-2">Nombre</p>
                            <p class="text-white font-medium text-lg">{{ tipoEjercicio.nombre }}</p>
                        </div>
                        <div>
                            <p class="text-s text-slate-500 mb-2">Estado</p>
                            <span :class="[
                                'inline-flex px-3 py-1 rounded-full text-xs font-semibold',
                                tipoEjercicio.estado === 'activo'
                                    ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30'
                                    : 'bg-gray-500/20 text-gray-300 border border-gray-500/30'
                            ]">
                                {{ tipoEjercicio.estado === 'activo' ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </InfoCard>

                <!-- Fechas -->
                <InfoCard title="Registro">
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-slate-500">Creado</p>
                            <p class="text-white">{{ formatearFecha(tipoEjercicio.created_at) }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Última actualización</p>
                            <p class="text-white">{{ formatearFecha(tipoEjercicio.updated_at) }}</p>
                        </div>
                    </div>
                </InfoCard>

            </div>

        </div>
    </AppLayout>
</template>

<style scoped>
.font-display {
    font-family: 'Oswald', sans-serif;
}
</style>

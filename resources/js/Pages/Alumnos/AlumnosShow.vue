<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import EstadoBadge from '@/Components/EstadoBadge.vue';
import InfoCard from '@/Components/InfoCard.vue';
import ConfirmModal from '@/Components/Feedback/ConfirmModal.vue';
import { useAlumno } from '@/Composables/useAlumno';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ChevronLeftIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    alumno: {
        type: Object,
        required: true
    }
})

const { calcularEdad, formatearFecha } = useAlumno()

const deleteForm = useForm({});
const showConfirm = ref(false);

const destroyAlumno = () => {
    showConfirm.value = true;
};

const closeConfirm = () => {
    showConfirm.value = false;
};

const confirmDelete = () => {
    deleteForm.delete(route('alumnos.destroy', props.alumno.id), {
        onFinish: () => {
            closeConfirm();
        }
    });
};
</script>

<template>
    <AppLayout title="Detalle Alumno">
        <ConfirmModal :show="showConfirm" title="Eliminar alumno"
            message="Estas seguro de eliminar este alumno? Esta accion no se puede deshacer." confirm-text="Eliminar"
            :loading="deleteForm.processing" @confirm="confirmDelete" @cancel="closeConfirm" />
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <Link :href="route('alumnos.index')" class="text-slate-400 hover:text-white transition-colors">
                    <ChevronLeftIcon class="w-6 h-6" />
                </Link>
                <div class="flex items-center gap-4 flex-1">
                    <div
                        class="h-20 w-20 rounded-full bg-blue-600/30 flex items-center justify-center text-2xl font-semibold text-blue-300">
                        {{ alumno.nombres.charAt(0) }}{{ alumno.apellidos.charAt(0) }}
                    </div>
                    <div>
                        <p class="text-m uppercase tracking-[0.3em] text-blue-300">Alumno</p>
                        <h2 class="text-4xl font-display text-white">{{ alumno.nombres }} {{ alumno.apellidos }}</h2>
                        <p class="text-slate-400 mt-1 capitalize">{{ alumno.genero }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" @click="destroyAlumno" :disabled="deleteForm.processing"
                        class="border border-red-500/40 text-red-200 px-6 py-3 rounded-xl font-semibold hover:bg-red-500/10 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Eliminar
                    </button>
                    <Link :href="route('alumnos.edit', alumno.id)"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
                        Editar Alumno
                    </Link>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">

                <!-- Columna principal -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Estado -->
                    <div class="bg-white/5 border border-white/10 rounded-xl p-6">
                        <EstadoBadge :estado="alumno.estado" />
                    </div>

                    <!-- Datos Personales -->
                    <InfoCard title="Datos Personales">
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-s text-slate-500 mb-2">Fecha de Nacimiento</p>
                                <p class="text-white font-medium text-lg">{{ formatearFecha(alumno.fecha_nacimiento) }}
                                </p>
                                <p class="text-slate-400 text-sm mt-1">{{ calcularEdad(alumno.fecha_nacimiento) }} años
                                </p>
                            </div>
                            <div>
                                <p class="text-s text-slate-500 mb-2">Género</p>
                                <p class="text-white font-medium text-lg capitalize">{{ alumno.genero }}</p>
                            </div>
                        </div>
                    </InfoCard>

                    <!-- Datos Físicos -->
                    <InfoCard title="Datos Físicos">
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-s text-slate-500 mb-2">Altura</p>
                                <p class="text-white font-medium text-2xl">{{ alumno.altura_cm }} <span
                                        class="text-lg text-slate-400">cm</span></p>
                            </div>
                            <div>
                                <p class="text-s text-slate-500 mb-2">Peso Inicial</p>
                                <p class="text-white font-medium text-2xl">
                                    {{ alumno.peso_inicial_kg || '—' }}
                                    <span v-if="alumno.peso_inicial_kg" class="text-lg text-slate-400">kg</span>
                                </p>
                            </div>
                        </div>
                    </InfoCard>

                    <!-- Objetivo -->
                    <InfoCard title="Objetivo">
                        <p class="text-slate-300 text-lg">{{ alumno.objetivo || 'Sin objetivo definido' }}</p>
                    </InfoCard>

                </div>

                <!-- Sidebar -->
                <div class="space-y-6">

                    <!-- Información de Contacto -->
                    <InfoCard title="Contacto">
                        <div class="space-y-4">
                            <div>
                                <p class="text-s text-slate-500 mb-2">Email</p>
                                <p class="text-white font-medium break-all">{{ alumno.email || '—' }}</p>
                            </div>
                            <div>
                                <p class="text-s text-slate-500 mb-2">Teléfono</p>
                                <p class="text-white font-medium">{{ alumno.telefono || '—' }}</p>
                            </div>
                        </div>
                    </InfoCard>

                    <!-- Fechas -->
                    <InfoCard title="Registro">
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-slate-500">Creado</p>
                                <p class="text-white">{{ formatearFecha(alumno.created_at) }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500">Última actualización</p>
                                <p class="text-white">{{ formatearFecha(alumno.updated_at) }}</p>
                            </div>
                        </div>
                    </InfoCard>

                    <!-- Notas -->
                    <InfoCard v-if="alumno.notas" title="Notas">
                        <p class="text-slate-300 whitespace-pre-wrap">{{ alumno.notas }}</p>
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
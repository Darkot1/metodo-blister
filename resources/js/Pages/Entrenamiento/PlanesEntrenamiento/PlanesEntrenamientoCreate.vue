<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormSelect from '@/Components/Form/FormSelect.vue';
import FormTextarea from '@/Components/Form/FormTextarea.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ChevronLeftIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    alumnos: {
        type: Array,
        default: () => []
    }
})

const form = useForm({
    alumno_id: '',
    nombre: '',
    objetivo: '',
    frecuencia_semanal: '3',
    fecha_inicio: '',
    fecha_fin: '',
    estado: 'activo',
})

const submit = () => {
    form.post(route('planes-entrenamiento.store'))
}
</script>

<template>
    <AppLayout title="Crear Plan de Entrenamiento">
        <div class="-m-8 min-h-full p-6">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-5">
                <Link :href="route('planes-entrenamiento.index')"
                    class="text-slate-400 hover:text-white transition-colors flex-shrink-0">
                    <ChevronLeftIcon class="w-5 h-5" />
                </Link>
                <div>
                    <p class="text-s uppercase tracking-[0.3em] text-blue-300">Nuevo</p>
                    <h2 class="text-3xl font-display text-white">Crear Plan de Entrenamiento</h2>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="bg-white/5 border border-white/10 p-6 rounded-2xl">

                <div class="grid lg:grid-cols-2 gap-x-8 gap-y-4">

                    <!-- ── Columna izquierda: Información básica ── -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-white mb-4">Información Básica</h3>

                        <FormSelect id="alumno_id" v-model="form.alumno_id" label="Alumno"
                            :error="form.errors.alumno_id" required>
                            <option value="">Selecciona un alumno</option>
                            <option v-for="alumno in alumnos" :key="alumno.id" :value="alumno.id">
                                {{ alumno.nombres }} {{ alumno.apellidos }}
                            </option>
                        </FormSelect>

                        <FormInput id="nombre" v-model="form.nombre" label="Nombre del plan" type="text"
                            placeholder="Plan semana 1" :error="form.errors.nombre" required />

                        <FormSelect id="frecuencia_semanal" v-model="form.frecuencia_semanal" label="Frecuencia semanal"
                            :error="form.errors.frecuencia_semanal" required>
                            <option value="1">1 día por semana</option>
                            <option value="2">2 días por semana</option>
                            <option value="3">3 días por semana</option>
                            <option value="4">4 días por semana</option>
                            <option value="5">5 días por semana</option>
                            <option value="6">6 días por semana</option>
                            <option value="7">7 días por semana</option>
                        </FormSelect>
                    </div>

                    <!-- ── Columna derecha: Detalles ── -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-white mb-4">Detalles</h3>

                        <FormInput id="fecha_inicio" v-model="form.fecha_inicio" label="Fecha de inicio" type="date"
                            :error="form.errors.fecha_inicio" required />

                        <FormInput id="fecha_fin" v-model="form.fecha_fin" label="Fecha de fin (opcional)" type="date"
                            :error="form.errors.fecha_fin" />

                        <FormSelect id="estado" v-model="form.estado" label="Estado" :error="form.errors.estado"
                            required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </FormSelect>
                    </div>

                </div>

                <!-- Objetivo -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-white mb-4">Objetivo del Plan</h3>
                    <FormTextarea id="objetivo" v-model="form.objetivo" label="Objetivo (opcional)"
                        placeholder="Describe los objetivos del plan de entrenamiento..." :error="form.errors.objetivo"
                        rows="4" />
                </div>

                <!-- Botones -->
                <div class="flex gap-4 mt-8">
                    <button type="submit" :disabled="form.processing"
                        class="bg-blue-600 hover:bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold py-3 px-8 rounded-xl transition shadow-lg shadow-blue-600/30">
                        Crear Plan
                    </button>
                    <Link :href="route('planes-entrenamiento.index')"
                        class="border border-slate-600 hover:border-slate-500 text-slate-300 hover:text-white font-semibold py-3 px-8 rounded-xl transition">
                        Cancelar
                    </Link>
                </div>

            </form>

        </div>
    </AppLayout>
</template>

<style scoped>
.font-display {
    font-family: 'Oswald', sans-serif;
}
</style>

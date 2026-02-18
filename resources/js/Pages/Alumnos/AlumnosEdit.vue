<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormSelect from '@/Components/Form/FormSelect.vue';
import FormTextarea from '@/Components/Form/FormTextarea.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    alumno: {
        type: Object,
        required: true,
    },
});

const toDateInput = (value) => {
    if (!value) return '';
    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return '';
    return date.toISOString().slice(0, 10);
};

const form = useForm({
    nombres: props.alumno.nombres ?? '',
    apellidos: props.alumno.apellidos ?? '',
    genero: props.alumno.genero ?? '',
    fecha_nacimiento: toDateInput(props.alumno.fecha_nacimiento),
    altura_cm: props.alumno.altura_cm ?? '',
    peso_inicial_kg: props.alumno.peso_inicial_kg ?? '',
    telefono: props.alumno.telefono ?? '',
    email: props.alumno.email ?? '',
    objetivo: props.alumno.objetivo ?? '',
    estado: props.alumno.estado ?? 'activo',
    notas: props.alumno.notas ?? '',
});

const submit = () => {
    form.put(route('alumnos.update', props.alumno.id));
};
</script>

<template>
    <AppLayout title="Editar Alumno">
        <div class="-m-8 min-h-full p-6">

            <!-- Header -->
            <div class="flex items-center gap-6 mb-8 ">
                <Link :href="route('alumnos.show', props.alumno.id)"
                    class="text-slate-400 hover:text-white transition-colors flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </Link>
                <div class="flex items-center gap-5 flex-1 ">
                    <div
                        class="h-20 w-20 rounded-full bg-blue-600/30 flex items-center justify-center text-2xl font-semibold text-blue-300">
                        {{ props.alumno.nombres.charAt(0) }}{{ props.alumno.apellidos.charAt(0) }}
                    </div>
                    <div>
                        <p class="text-s uppercase tracking-[0.3em] text-blue-300">Editar</p>
                        <h2 class="text-4xl font-display text-white">Actualizar Alumno</h2>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="bg-white/5 border border-white/10 p-6 rounded-2xl">

                <div class="grid lg:grid-cols-2 gap-x-8 gap-y-4">

                    <!-- ── Columna izquierda: Datos personales ── -->
                    <div class="space-y-4">
                        <p
                            class="text-s uppercase tracking-[0.2em] text-blue-300 font-semibold pb-1 border-b border-white/10">
                            Datos personales
                        </p>

                        <div class="grid grid-cols-2 gap-4">
                            <FormInput id="nombres" v-model="form.nombres" label="Nombres" placeholder="Juan"
                                :error="form.errors.nombres" />
                            <FormInput id="apellidos" v-model="form.apellidos" label="Apellidos" placeholder="Pérez"
                                :error="form.errors.apellidos" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <FormSelect id="genero" v-model="form.genero" label="Género" :error="form.errors.genero">
                                <option value="" disabled class="bg-slate-900">Seleccionar...</option>
                                <option value="masculino" class="bg-slate-900">Masculino</option>
                                <option value="femenino" class="bg-slate-900">Femenino</option>
                            </FormSelect>
                            <FormInput id="fecha_nacimiento" v-model="form.fecha_nacimiento" label="Fecha de nacimiento"
                                type="date" :error="form.errors.fecha_nacimiento" />
                        </div>

                        <FormInput id="objetivo" v-model="form.objetivo" label="Objetivo"
                            placeholder="Ej: Bajar grasa, ganar músculo, mejorar fuerza" />
                    </div>

                    <!-- ── Columna derecha: Datos físicos y contacto ── -->
                    <div class="space-y-4">
                        <p
                            class="text-s uppercase tracking-[0.2em] text-blue-300 font-semibold pb-1 border-b border-white/10">
                            Datos físicos y contacto
                        </p>

                        <div class="grid grid-cols-2 gap-4">
                            <FormInput id="altura_cm" v-model="form.altura_cm" label="Altura (cm)" type="number"
                                placeholder="175" :error="form.errors.altura_cm" />
                            <FormInput id="peso_inicial_kg" v-model="form.peso_inicial_kg" label="Peso inicial (kg)"
                                type="number" step="0.01" placeholder="70.5" :error="form.errors.peso_inicial_kg" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <FormInput id="telefono" v-model="form.telefono" label="Teléfono"
                                placeholder="+34 123 456 789" />
                            <FormInput id="email" v-model="form.email" label="Correo electrónico" type="email"
                                placeholder="alumno@email.com" :error="form.errors.email" />
                        </div>

                        <FormSelect id="estado" v-model="form.estado" label="Estado">
                            <option value="activo" class="bg-slate-900">Activo</option>
                            <option value="en_pausa" class="bg-slate-900">En pausa</option>
                            <option value="inactivo" class="bg-slate-900">Inactivo</option>
                        </FormSelect>

                        <FormTextarea id="notas" v-model="form.notas" label="Notas (opcional)"
                            placeholder="Lesiones, restricciones, observaciones especiales..." rows="3" />
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-5 mt-5 border-t border-white/10">
                    <button type="submit" :disabled="form.processing"
                        class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-500 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-blue-600/30">
                        {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                    </button>
                    <Link :href="route('alumnos.show', props.alumno.id)"
                        class="px-8 py-3 rounded-xl border border-white/10 text-slate-300 hover:text-white hover:border-white/20 transition font-semibold">
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
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormSelect from '@/Components/Form/FormSelect.vue';
import FormTextarea from '@/Components/Form/FormTextarea.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ChevronLeftIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    ejercicio: {
        type: Object,
        required: true,
    },
    tiposEjercicio: {
        type: Array,
        default: () => []
    }
});

const form = useForm({
    nombre: props.ejercicio.nombre ?? '',
    descripcion: props.ejercicio.descripcion ?? '',
    grupo_muscular: props.ejercicio.grupo_muscular ?? '',
    tipo_ejercicio_id: props.ejercicio.tipo_ejercicio_id ?? '',
    nivel: props.ejercicio.nivel ?? '',
    video_url: props.ejercicio.video_url ?? '',
    estado: props.ejercicio.estado ?? 'activo',
});

const submit = () => {
    form.put(route('ejercicios.update', props.ejercicio.id));
};
</script>

<template>
    <AppLayout title="Editar Ejercicio">
        <div class="-m-8 min-h-full p-6">

            <!-- Header -->
            <div class="flex items-center gap-6 mb-8">
                <Link :href="route('ejercicios.show', props.ejercicio.id)"
                    class="text-slate-400 hover:text-white transition-colors flex-shrink-0">
                    <ChevronLeftIcon class="w-5 h-5" />
                </Link>
                <div class="flex items-center gap-5 flex-1">
                    <div
                        class="h-20 w-20 rounded-full bg-blue-600/30 flex items-center justify-center text-2xl font-semibold text-blue-300">
                        {{ props.ejercicio.nombre.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <p class="text-s uppercase tracking-[0.3em] text-blue-300">Editar</p>
                        <h2 class="text-4xl font-display text-white">Actualizar Ejercicio</h2>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="bg-white/5 border border-white/10 p-6 rounded-2xl">

                <div class="grid lg:grid-cols-2 gap-x-8 gap-y-4">

                    <!-- ── Columna izquierda: Información básica ── -->
                    <div class="space-y-4">
                        <p
                            class="text-s uppercase tracking-[0.2em] text-blue-300 font-semibold pb-1 border-b border-white/10">
                            Información básica
                        </p>

                        <FormInput id="nombre" v-model="form.nombre" label="Nombre del ejercicio"
                            placeholder="ej: Sentadilla, Flexiones, Dominadas" :error="form.errors.nombre" />

                        <FormSelect id="tipo_ejercicio_id" v-model="form.tipo_ejercicio_id" label="Tipo de ejercicio"
                            :error="form.errors.tipo_ejercicio_id">
                            <option value="" disabled class="bg-slate-900">Seleccionar...</option>
                            <option v-for="tipo in tiposEjercicio" :key="tipo.id" :value="tipo.id" class="bg-slate-900">
                                {{ tipo.nombre }}
                            </option>
                        </FormSelect>

                        <FormInput id="grupo_muscular" v-model="form.grupo_muscular" label="Grupo muscular"
                            placeholder="ej: Pecho, Piernas, Espalda" :error="form.errors.grupo_muscular" />

                        <FormSelect id="nivel" v-model="form.nivel" label="Nivel de dificultad"
                            :error="form.errors.nivel">
                            <option value="" disabled class="bg-slate-900">Seleccionar...</option>
                            <option value="principiante" class="bg-slate-900">Principiante</option>
                            <option value="intermedio" class="bg-slate-900">Intermedio</option>
                            <option value="avanzado" class="bg-slate-900">Avanzado</option>
                        </FormSelect>
                    </div>

                    <!-- ── Columna derecha: Detalles y estado ── -->
                    <div class="space-y-4">
                        <p
                            class="text-s uppercase tracking-[0.2em] text-blue-300 font-semibold pb-1 border-b border-white/10">
                            Detalles
                        </p>

                        <FormInput id="video_url" v-model="form.video_url" label="URL del video (opcional)"
                            placeholder="https://youtube.com/..." type="url" :error="form.errors.video_url" />

                        <FormSelect id="estado" v-model="form.estado" label="Estado">
                            <option value="activo" class="bg-slate-900">Activo</option>
                            <option value="inactivo" class="bg-slate-900">Inactivo</option>
                        </FormSelect>

                        <FormTextarea id="descripcion" v-model="form.descripcion" label="Descripción (opcional)"
                            placeholder="Describir técnica, beneficios, variaciones..." rows="5" />
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-5 mt-5 border-t border-white/10">
                    <button type="submit" :disabled="form.processing"
                        class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-500 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-blue-600/30">
                        {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                    </button>
                    <Link :href="route('ejercicios.show', props.ejercicio.id)"
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

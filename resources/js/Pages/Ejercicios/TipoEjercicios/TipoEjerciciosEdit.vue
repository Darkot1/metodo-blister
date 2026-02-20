<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormSelect from '@/Components/Form/FormSelect.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ChevronLeftIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    tipoEjercicio: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    nombre: props.tipoEjercicio.nombre ?? '',
    estado: props.tipoEjercicio.estado ?? 'activo',
});

const submit = () => {
    form.put(route('tipo-ejercicios.update', props.tipoEjercicio.id));
};
</script>

<template>
    <AppLayout title="Editar Tipo de Ejercicio">
        <div class="-m-8 min-h-full p-6">

            <!-- Header -->
            <div class="flex items-center gap-6 mb-8">
                <Link :href="route('tipo-ejercicios.show', props.tipoEjercicio.id)"
                    class="text-slate-400 hover:text-white transition-colors flex-shrink-0">
                    <ChevronLeftIcon class="w-5 h-5" />
                </Link>
                <div class="flex items-center gap-5 flex-1">
                    <div
                        class="h-20 w-20 rounded-full bg-blue-600/30 flex items-center justify-center text-2xl font-semibold text-blue-300">
                        {{ props.tipoEjercicio.nombre.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <p class="text-s uppercase tracking-[0.3em] text-blue-300">Editar</p>
                        <h2 class="text-4xl font-display text-white">Actualizar Tipo</h2>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="bg-white/5 border border-white/10 p-6 rounded-2xl max-w-2xl">

                <div class="space-y-4">
                    <FormInput id="nombre" v-model="form.nombre" label="Nombre del tipo"
                        placeholder="Ej: Fuerza, Cardio, Flexibilidad" :error="form.errors.nombre" />

                    <FormSelect id="estado" v-model="form.estado" label="Estado">
                        <option value="activo" class="bg-slate-900">Activo</option>
                        <option value="inactivo" class="bg-slate-900">Inactivo</option>
                    </FormSelect>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-5 mt-5 border-t border-white/10">
                    <button type="submit" :disabled="form.processing"
                        class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-500 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-blue-600/30">
                        {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                    </button>
                    <Link :href="route('tipo-ejercicios.show', props.tipoEjercicio.id)"
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

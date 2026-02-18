<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormSelect from '@/Components/Form/FormSelect.vue';
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
    estado: 'activo',
})

const submit = () => {
    form.post(route('tipo-ejercicios.store'))
}
</script>

<template>
    <AppLayout title="Crear Tipo de Ejercicio">
        <div class="-m-8 min-h-full p-6">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-5">
                <Link :href="route('tipo-ejercicios.index')"
                    class="text-slate-400 hover:text-white transition-colors flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </Link>
                <div>
                    <p class="text-s uppercase tracking-[0.3em] text-blue-300">Nuevo</p>
                    <h2 class="text-3xl font-display text-white">Crear Tipo de Ejercicio</h2>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="bg-white/5 border border-white/10 p-6 rounded-2xl max-w-2xl mx-auto">

                <div class="space-y-4">
                    <FormInput id="nombre" v-model="form.nombre" label="Nombre del tipo"
                        placeholder="Nombre del tipo de ejercicio (p. ej. Mancuerna, Barra, Cardio)"
                        :error="form.errors.nombre" />

                    <FormSelect id="estado" v-model="form.estado" label="Estado">
                        <option value="activo" class="bg-slate-900">Activo</option>
                        <option value="inactivo" class="bg-slate-900">Inactivo</option>
                    </FormSelect>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-5 mt-5 border-t border-white/10">
                    <button type="submit" :disabled="form.processing"
                        class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-500 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-blue-600/30">
                        {{ form.processing ? 'Guardando...' : 'Crear tipo' }}
                    </button>
                    <Link :href="route('tipo-ejercicios.index')"
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

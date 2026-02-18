<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    tipoEjercicios: {
        type: Array,
        default: () => []
    }
})
</script>

<template>
    <AppLayout title="Tipos de Ejercicio">
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-blue-300">Gestión</p>
                    <h2 class="text-4xl font-display text-white">Tipos de Ejercicio</h2>
                </div>
                <Link :href="route('tipo-ejercicios.create')"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Crear tipo
                </Link>
            </div>

            <!-- Stats -->
            <div class="grid sm:grid-cols-2 gap-4 mb-8">
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-white">{{ tipoEjercicios.length }}</p>
                    <p class="text-slate-400 text-sm mt-1">Total tipos</p>
                </div>
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-blue-300">{{tipoEjercicios.filter(t => t.estado ===
                        'activo').length}}</p>
                    <p class="text-slate-400 text-sm mt-1">Tipos activos</p>
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-2xl border border-white/10 bg-white/5 overflow-hidden">

                <!-- Empty state -->
                <div v-if="tipoEjercicios.length === 0" class="py-24 text-center">
                    <div
                        class="mx-auto h-14 w-14 rounded-2xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-slate-300 font-semibold text-lg">No hay tipos de ejercicio registrados</p>
                    <p class="text-slate-500 text-sm mt-1">Crea el primer tipo para comenzar</p>
                    <Link :href="route('tipo-ejercicios.create')"
                        class="inline-flex items-center gap-2 mt-6 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition">
                        Crear tipo
                    </Link>
                </div>

                <!-- Table data -->
                <table v-else class="w-full text-m text-slate-300">
                    <thead>
                        <tr class="border-b border-white/10 bg-slate-900/60">
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                Nombre</th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold hidden lg:table-cell">
                                Fecha de creación</th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr v-for="tipo in tipoEjercicios" :key="tipo.id"
                            @click="$inertia.visit(route('tipo-ejercicios.show', tipo.id))"
                            class="hover:bg-white/5 transition-colors cursor-pointer">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <p class="font-semibold text-white">{{ tipo.nombre }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <p class="text-slate-400">{{ new Date(tipo.created_at).toLocaleDateString('es-ES') }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <span :class="[
                                    'inline-flex px-2.5 py-1 rounded-full text-xs font-semibold',
                                    tipo.estado === 'activo'
                                        ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30'
                                        : 'bg-gray-500/20 text-gray-300 border border-gray-500/30'
                                ]">
                                    {{ tipo.estado === 'activo' ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.font-display {
    font-family: 'Oswald', sans-serif;
}
</style>
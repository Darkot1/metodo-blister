<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import EstadoBadge from '@/Components/EstadoBadge.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { PlusIcon, TableCellsIcon, MapPinIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { usePlan } from '@/Composables/usePlan';

const { getFrequencia, formatearFecha, calcularDuracion } = usePlan();

defineProps({
    planes: {
        type: Array,
        default: () => []
    }
})

const deleteForm = useForm({});

const deletePlan = (planId) => {
    if (window.confirm('¿Seguro que quieres eliminar este plan? Esta acción no se puede deshacer.')) {
        deleteForm.delete(route('planes-entrenamiento.destroy', planId));
    }
};
</script>

<template>
    <AppLayout title="Planes de Entrenamiento">
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-blue-300">Gestión</p>
                    <h2 class="text-4xl font-display text-white">Planes de Entrenamiento</h2>
                </div>
                <Link :href="route('planes-entrenamiento.create')"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
                    <PlusIcon class="w-4 h-4" />
                    Crear plan
                </Link>
            </div>

            <!-- Stats -->
            <div class="grid sm:grid-cols-3 gap-4 mb-8">
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-white">{{ planes.length }}</p>
                    <p class="text-slate-400 text-sm mt-1">Total planes</p>
                </div>
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-blue-300">{{planes.filter(p => p.estado === 'activo').length
                        }}</p>
                    <p class="text-slate-400 text-sm mt-1">Planes activos</p>
                </div>
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-yellow-300">{{planes.filter(p => p.estado ===
                        'inactivo').length}}</p>
                    <p class="text-slate-400 text-sm mt-1">Planes inactivos</p>
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-2xl border border-white/10 bg-white/5 overflow-hidden">

                <!-- Empty state -->
                <div v-if="planes.length === 0" class="py-24 text-center">
                    <div
                        class="mx-auto h-14 w-14 rounded-2xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center mb-5">
                        <TableCellsIcon class="w-6 h-6 text-blue-300" />
                    </div>
                    <p class="text-slate-300 font-semibold text-lg">No hay planes de entrenamiento</p>
                    <p class="text-slate-500 text-sm mt-1">Crea el primer plan para comenzar</p>
                    <Link :href="route('planes-entrenamiento.create')"
                        class="inline-flex items-center gap-2 mt-6 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition">
                        Crear plan
                    </Link>
                </div>

                <!-- Table data -->
                <table v-else class="w-full text-sm text-slate-300">
                    <thead>
                        <tr class="border-b border-white/10 bg-slate-900/60">
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                Nombre
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold hidden md:table-cell">
                                Alumno
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold hidden lg:table-cell">
                                Objetivo
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold hidden xl:table-cell">
                                Inicio
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold hidden xl:table-cell">
                                Fin
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold hidden sm:table-cell">
                                Duración
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                Estado
                            </th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr v-for="plan in planes" :key="plan.id"
                            @click="$inertia.visit(route('planes-entrenamiento.show', plan.id))"
                            class="hover:bg-white/5 transition-colors cursor-pointer">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-white">{{ plan.nombre }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ getFrequencia(plan.frecuencia_semanal)
                                    }} semanal</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <p class="text-slate-300">{{ plan.alumno?.nombres }} {{ plan.alumno?.apellidos }}</p>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <p class="text-slate-400 line-clamp-2 max-w-xs text-sm">{{ plan.objetivo || '—' }}</p>
                            </td>
                            <td class="px-6 py-4 hidden xl:table-cell">
                                <p class="text-slate-400 text-sm">{{ formatearFecha(plan.fecha_inicio) }}</p>
                            </td>
                            <td class="px-6 py-4 hidden xl:table-cell">
                                <p class="text-slate-400 text-sm">{{ formatearFecha(plan.fecha_fin) }}</p>
                            </td>
                            <td class="px-6 py-4 hidden sm:table-cell">
                                <p class="text-slate-400 text-sm font-medium">{{ calcularDuracion(plan.fecha_inicio,
                                    plan.fecha_fin) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <EstadoBadge :estado="plan.estado" />
                            </td>
                            <td class="px-6 py-4 text-right" @click.stop>
                                <button @click="deletePlan(plan.id)" :disabled="deleteForm.processing"
                                    class="text-red-400 hover:text-red-300 transition-colors disabled:opacity-50">
                                    <TrashIcon class="w-4 h-4" />
                                </button>
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

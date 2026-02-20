<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import EstadoBadge from '@/Components/EstadoBadge.vue';
import { Link } from '@inertiajs/vue3';
import { PlusIcon, TableCellsIcon, MapPinIcon } from '@heroicons/vue/24/outline';

defineProps({
    ejercicios: {
        type: Array,
        default: () => []
    }
})

const getNivelColor = (nivel) => {
    const colores = {
        'principiante': 'text-green-300',
        'intermedio': 'text-yellow-300',
        'avanzado': 'text-red-300'
    };
    return colores[nivel] || 'text-slate-300';
};

const getNivelLabel = (nivel) => {
    const labels = {
        'principiante': 'Principiante',
        'intermedio': 'Intermedio',
        'avanzado': 'Avanzado'
    };
    return labels[nivel] || nivel;
};
</script>

<template>
    <AppLayout title="Ejercicios">
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-blue-300">Gestión</p>
                    <h2 class="text-4xl font-display text-white">Ejercicios</h2>
                </div>
                <div class="flex items-center gap-3">
                    <Link :href="route('tipo-ejercicios.index')"
                        class="inline-flex items-center gap-2 bg-slate-700 text-white px-6 py-3 rounded-xl font-semibold hover:bg-slate-600 transition">
                        <TableCellsIcon class="w-4 h-4" />
                        Tipos de ejercicios
                    </Link>
                    <Link :href="route('ejercicios.create')"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
                        <PlusIcon class="w-4 h-4" />
                        Agregar ejercicio
                    </Link>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid sm:grid-cols-4 gap-4 mb-8">
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-white">{{ ejercicios.length }}</p>
                    <p class="text-slate-400 text-sm mt-1">Total ejercicios</p>
                </div>
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-green-300">{{ejercicios.filter(e => e.nivel ===
                        'principiante').length}}</p>
                    <p class="text-slate-400 text-sm mt-1">Principiante</p>
                </div>
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-yellow-300">{{ejercicios.filter(e => e.nivel ===
                        'intermedio').length}}</p>
                    <p class="text-slate-400 text-sm mt-1">Intermedio</p>
                </div>
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-red-300">{{ejercicios.filter(e => e.nivel ===
                        'avanzado').length}}</p>
                    <p class="text-slate-400 text-sm mt-1">Avanzado</p>
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-2xl border border-white/10 bg-white/5 overflow-hidden">

                <!-- Empty state -->
                <div v-if="ejercicios.length === 0" class="py-24 text-center">
                    <div
                        class="mx-auto h-14 w-14 rounded-2xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center mb-5">
                        <MapPinIcon class="w-6 h-6 text-blue-300" />
                    </div>
                    <p class="text-slate-300 font-semibold text-lg">No hay ejercicios registrados</p>
                    <p class="text-slate-500 text-sm mt-1">Registra tu primer ejercicio para comenzar</p>
                    <Link :href="route('ejercicios.create')"
                        class="inline-flex items-center gap-2 mt-6 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition">
                        <PlusIcon class="w-4 h-4" />
                        Agregar ejercicio
                    </Link>
                </div>

                <!-- Table data -->
                <table v-else class="w-full text-sm text-slate-300">
                    <thead>
                        <tr class="border-b border-white/10 bg-slate-900/60">
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                Ejercicio</th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold hidden md:table-cell">
                                Tipo</th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold hidden lg:table-cell">
                                Grupo Muscular</th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                Nivel</th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                Estado</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr v-for="ejercicio in ejercicios" :key="ejercicio.id"
                            @click="$inertia.visit(route('ejercicios.show', ejercicio.id))"
                            class="hover:bg-white/5 transition-colors cursor-pointer">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-full bg-blue-600/30 flex items-center justify-center text-sm font-semibold text-blue-300 flex-shrink-0">
                                        {{ ejercicio.nombre.charAt(0).toUpperCase() }}
                                    </div>
                                    <p class="font-semibold text-white">{{ ejercicio.nombre }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <p class="text-slate-400">{{ ejercicio.tipo_ejercicio?.nombre || '—' }}</p>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <p class="text-slate-400 capitalize">{{ ejercicio.grupo_muscular || '—' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span :class="['font-semibold capitalize', getNivelColor(ejercicio.nivel)]">
                                    {{ getNivelLabel(ejercicio.nivel) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <EstadoBadge :estado="ejercicio.estado" />
                            </td>
                            <td class="px-6 py-4 text-right" @click.stop>
                                <Link :href="route('ejercicios.edit', ejercicio.id)"
                                    class="text-slate-400 hover:text-white transition-colors text-xs font-semibold">
                                    Editar
                                </Link>
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

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import EstadoBadge from '@/Components/EstadoBadge.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    alumnos: {
        type: Array,
        default: () => []
    }
})
</script>

<template>
    <AppLayout title="Alumnos">
        <div class="-m-8 min-h-full bg-slate-950 p-8">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-blue-300">Gestión</p>
                    <h2 class="text-4xl font-display text-white">Alumnos</h2>
                </div>
                <Link :href="route('alumnos.create')"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Registrar alumno
                </Link>
            </div>

            <!-- Stats -->
            <div class="grid sm:grid-cols-3 gap-4 mb-8">
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-white">{{ alumnos.length }}</p>
                    <p class="text-slate-400 text-sm mt-1">Total alumnos</p>
                </div>
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-blue-300">{{alumnos.filter(a => a.estado ===
                        'activo').length}}</p>
                    <p class="text-slate-400 text-sm mt-1">Activos</p>
                </div>
                <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                    <p class="text-3xl font-semibold text-yellow-300">{{alumnos.filter(a => a.estado ===
                        'en_pausa').length}}</p>
                    <p class="text-slate-400 text-sm mt-1">En pausa</p>
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-2xl border border-white/10 bg-white/5 overflow-hidden">

                <!-- Empty state -->
                <div v-if="alumnos.length === 0" class="py-24 text-center">
                    <div
                        class="mx-auto h-14 w-14 rounded-2xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </div>
                    <p class="text-slate-300 font-semibold text-lg">No hay alumnos registrados</p>
                    <p class="text-slate-500 text-sm mt-1">Registra tu primer alumno para comenzar</p>
                    <Link :href="route('alumnos.create')"
                        class="inline-flex items-center gap-2 mt-6 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-500 transition">
                        Registrar alumno
                    </Link>
                </div>

                <!-- Table data -->
                <table v-else class="w-full text-sm text-slate-300">
                    <thead>
                        <tr class="border-b border-white/10 bg-slate-900/60">
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                Alumno</th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold hidden md:table-cell">
                                Contacto</th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold hidden lg:table-cell">
                                Objetivo</th>
                            <th
                                class="px-6 py-4 text-left text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                Estado</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr v-for="alumno in alumnos" :key="alumno.id"
                            @click="$inertia.visit(route('alumnos.show', alumno.id))"
                            class="hover:bg-white/5 transition-colors cursor-pointer">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-full bg-blue-600/30 flex items-center justify-center text-sm font-semibold text-blue-300 flex-shrink-0">
                                        {{ alumno.nombres.charAt(0) }}{{ alumno.apellidos.charAt(0) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white">{{ alumno.nombres }} {{ alumno.apellidos }}
                                        </p>
                                        <p class="text-xs text-slate-500 capitalize">{{ alumno.genero }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <p>{{ alumno.email || '—' }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ alumno.telefono || '—' }}</p>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <p class="line-clamp-2 max-w-xs text-slate-400 text-sm">{{ alumno.objetivo || '—' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <EstadoBadge :estado="alumno.estado" />
                            </td>
                            <td class="px-6 py-4 text-right" @click.stop>
                                <Link :href="route('alumnos.edit', alumno.id)"
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

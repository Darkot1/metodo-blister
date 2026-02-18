<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    nombres: '',
    apellidos: '',
    genero: '',
    fecha_nacimiento: '',
    altura_cm: '',
    peso_inicial_kg: '',
    telefono: '',
    email: '',
    objetivo: '',
    estado: 'activo',
    notas: '',
})

const submit = () => {
    form.post(route('alumnos.store'))
}
</script>

<template>
    <AppLayout title="Registrar Alumno">
        <div class="-m-8 min-h-full p-6">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-5">
                <Link :href="route('alumnos.index')"
                    class="text-slate-400 hover:text-white transition-colors flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </Link>
                <div>
                    <p class="text-s uppercase tracking-[0.3em] text-blue-300">Nuevo</p>
                    <h2 class="text-3xl font-display text-white">Registrar Alumno</h2>
                </div>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="bg-white/5 border border-white/10 p-6 rounded-2xl">

                <div class="grid lg:grid-cols-2 gap-x-8 gap-y-4">

                    <!-- ── Columna izquierda: Datos personales ── -->
                    <div class="space-y-4">
                        <p class="text-s uppercase tracking-[0.2em] text-blue-300 font-semibold pb-1 border-b border-white/10">
                            Datos personales
                        </p>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-s font-semibold text-slate-400 mb-1.5">Nombres</label>
                                <input v-model="form.nombres" type="text" placeholder="Juan"
                                    class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition placeholder:text-slate-700" />
                                <p v-if="form.errors.nombres" class="mt-1 text-xs text-red-400">{{ form.errors.nombres }}</p>
                            </div>
                            <div>
                                <label class="block text-s font-semibold text-slate-400 mb-1.5">Apellidos</label>
                                <input v-model="form.apellidos" type="text" placeholder="Pérez"
                                    class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition placeholder:text-slate-700" />
                                <p v-if="form.errors.apellidos" class="mt-1 text-xs text-red-400">{{ form.errors.apellidos }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-s font-semibold text-slate-400 mb-1.5">Género</label>
                                <select v-model="form.genero"
                                    class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition">
                                    <option value="" disabled class="bg-slate-900">Seleccionar...</option>
                                    <option value="masculino" class="bg-slate-900">Masculino</option>
                                    <option value="femenino" class="bg-slate-900">Femenino</option>
                                </select>
                                <p v-if="form.errors.genero" class="mt-1 text-xs text-red-400">{{ form.errors.genero }}</p>
                            </div>
                            <div>
                                <label class="block text-s font-semibold text-slate-400 mb-1.5">Fecha de nacimiento</label>
                                <input v-model="form.fecha_nacimiento" type="date"
                                    class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition" />
                                <p v-if="form.errors.fecha_nacimiento" class="mt-1 text-xs text-red-400">{{ form.errors.fecha_nacimiento }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-s font-semibold text-slate-400 mb-1.5">Objetivo</label>
                            <input v-model="form.objetivo" type="text"
                                placeholder="Ej: Bajar grasa, ganar músculo, mejorar fuerza"
                                class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition placeholder:text-slate-700" />
                        </div>
                    </div>

                    <!-- ── Columna derecha: Datos físicos y contacto ── -->
                    <div class="space-y-4">
                        <p class="text-s uppercase tracking-[0.2em] text-blue-300 font-semibold pb-1 border-b border-white/10">
                            Datos físicos y contacto
                        </p>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-s font-semibold text-slate-400 mb-1.5">Altura (cm)</label>
                                <input v-model="form.altura_cm" type="number" placeholder="175"
                                    class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition placeholder:text-slate-700" />
                                <p v-if="form.errors.altura_cm" class="mt-1 text-xs text-red-400">{{ form.errors.altura_cm }}</p>
                            </div>
                            <div>
                                <label class="block text-s font-semibold text-slate-400 mb-1.5">Peso inicial (kg)</label>
                                <input v-model="form.peso_inicial_kg" type="number" step="0.01" placeholder="70.5"
                                    class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition placeholder:text-slate-700" />
                                <p v-if="form.errors.peso_inicial_kg" class="mt-1 text-xs text-red-400">{{ form.errors.peso_inicial_kg }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-s font-semibold text-slate-400 mb-1.5">Teléfono</label>
                                <input v-model="form.telefono" type="text" placeholder="+34 123 456 789"
                                    class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition placeholder:text-slate-700" />
                            </div>
                            <div>
                                <label class="block text-s font-semibold text-slate-400 mb-1.5">Correo electrónico</label>
                                <input v-model="form.email" type="email" placeholder="alumno@email.com"
                                    class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition placeholder:text-slate-700" />
                                <p v-if="form.errors.email" class="mt-1 text-xs text-red-400">{{ form.errors.email }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-s font-semibold text-slate-400 mb-1.5">Estado</label>
                            <select v-model="form.estado"
                                class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition">
                                <option value="activo" class="bg-slate-900">Activo</option>
                                <option value="en_pausa" class="bg-slate-900">En pausa</option>
                                <option value="inactivo" class="bg-slate-900">Inactivo</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-s font-semibold text-slate-400 mb-1.5">Notas (opcional)</label>
                            <textarea v-model="form.notas"
                                placeholder="Lesiones, restricciones, observaciones especiales..." rows="3"
                                class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition resize-none placeholder:text-slate-700"></textarea>
                        </div>
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-5 mt-5 border-t border-white/10">
                    <button type="submit" :disabled="form.processing"
                        class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-500 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-blue-600/30">
                        {{ form.processing ? 'Guardando...' : 'Registrar alumno' }}
                    </button>
                    <Link :href="route('alumnos.index')"
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

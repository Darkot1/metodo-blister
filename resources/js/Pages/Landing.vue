<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
})

const form = useForm({
    name: '',
    email: '',
    phone: '',
    goal: '',
    message: ''
})

const submit = () => {
    form.post(route('contact.store'))
}
</script>

<template>

    <Head title="Método Blister - Entrenamiento Personalizado" />
    <div class="min-h-screen bg-slate-950 text-slate-100">
        <!-- LOGIN -->
        <div class="fixed top-4 right-4 z-50">
            <div v-if="$page.props.auth.user" class="flex items-center gap-2">
                <Link :href="route('dashboard')"
                    class="px-3 py-2 text-xs text-slate-200 hover:text-white transition rounded hover:bg-white/10">
                    Dashboard
                </Link>
            </div>
            <div v-else class="flex gap-2">
                <Link :href="route('login')" class="text-xs text-slate-300 hover:text-white transition font-semibold">
                    Iniciar Sesion
                </Link>
            </div>
        </div>

        <!-- HERO  -->
        <section class="relative overflow-hidden">
            <div class="absolute inset-0 hero-grid"></div>
            <div class="absolute -top-40 -right-40 w-[520px] h-[520px] rounded-full bg-blue-600/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-[520px] h-[520px] rounded-full bg-slate-700/40 blur-3xl"></div>

            <div class="max-w-7xl mx-auto px-6 py-24 relative">
                <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-12 items-center">
                    <div class="space-y-8 animate-rise max-w-3xl">
                        <div
                            class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs tracking-wide uppercase">
                            <span class="h-2 w-2 rounded-full bg-blue-400"></span>
                            Transformacion real en 90 dias
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-slate-400">Metodo Blister</p>
                            <h1 class="text-5xl md:text-6xl font-display leading-tight mt-4">
                                Deja de improvisar. Entrena con un plan que convierte esfuerzo en resultados.
                            </h1>
                        </div>
                        <p class="text-lg text-slate-300 max-w-2xl">
                            Si ya lo intentaste todo y te estancaste, el problema no eres tu: es la falta de estructura.
                            Construyo tu plan de fuerza, nutricion y seguimiento para que cada semana veas cambios
                            medibles.
                        </p>
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="#formulario"
                                class="inline-flex items-center justify-center bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
                                Agenda tu evaluacion
                            </a>
                            <div class="text-sm text-slate-400">
                                +120 transformaciones guiadas
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-3 gap-4 text-sm text-slate-300">
                            <div class="rounded-xl bg-white/5 border border-white/10 p-4">
                                <p class="text-blue-300 font-semibold">12 semanas</p>
                                <p class="text-slate-400">Plan progresivo personalizado</p>
                            </div>
                            <div class="rounded-xl bg-white/5 border border-white/10 p-4">
                                <p class="text-blue-300 font-semibold">Check-ins</p>
                                <p class="text-slate-400">Reajustes semanales</p>
                            </div>
                            <div class="rounded-xl bg-white/5 border border-white/10 p-4">
                                <p class="text-blue-300 font-semibold">Soporte</p>
                                <p class="text-slate-400">Contacto directo</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative animate-rise">
                        <div
                            class="relative h-[520px] rounded-3xl border-2 border-dashed border-white/15 bg-white/5 flex items-center justify-center">
                            <div class="text-center space-y-3">
                                <div
                                    class="mx-auto h-14 w-14 rounded-2xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-2xl">
                                    imagen del entrenador
                                </div>
                                <p class="text-sm text-slate-300 font-semibold">Imagen del entrenador</p>
                                
                            </div>
                        </div>
                        <div
                            class="absolute -bottom-8 -left-6 bg-slate-900/90 border border-white/10 rounded-2xl p-5 backdrop-blur">
                            <p class="text-sm text-slate-400">Resultado promedio</p>
                            <p class="text-2xl font-semibold text-white">-6% grasa en 90 dias</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- QUIEN SOY -->
        <section class="py-20 bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-[0.9fr_1.1fr] gap-12 items-center">
                    <div class="space-y-6">
                        <h2 class="text-4xl md:text-5xl font-display">Soy Kevin, entrenador de alto rendimiento.</h2>
                        <p class="text-slate-300">
                            Especialista en recomposicion corporal, fuerza aplicada y adherencia. He trabajado con
                            ejecutivos ocupados y atletas recreativos que necesitaban resultados claros sin sacrificar
                            su agenda.
                        </p>
                        <div class="grid sm:grid-cols-1 gap-4">
                            <div class="rounded-2xl bg-slate-950/70 border border-white/10 p-5">
                                <p class="text-3xl font-semibold text-white">4.9/5</p>
                                <p class="text-slate-400 text-sm">Valoracion en programas</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                            <p class="text-4xl font-display text-blue-300">""</p>
                            <p class="text-slate-300">
                                "Por fin un plan que se adapta a mi trabajo. Baje 8 kg sin sentir que vivia a dieta."
                            </p>
                            <p class="text-sm text-slate-500 mt-3">- Carlos M., 36</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                            <p class="text-4xl font-display text-blue-300">""</p>
                            <p class="text-slate-300">
                                "Me devolvio la motivacion. Las metas son claras y el seguimiento es brutal."
                            </p>
                            <p class="text-sm text-slate-500 mt-3">- Valeria R., 29</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SERVICIOS -->
        <section class="py-20 bg-slate-950">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-blue-300">Servicios</p>
                        <h2 class="text-4xl md:text-5xl font-display">Todo lo que necesitas para avanzar.</h2>
                    </div>
                    <p class="text-slate-400 max-w-xl">
                        Plan integral: entrenamiento, nutricion y seguimiento, todo bajo una sola estrategia.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div
                        class="group relative rounded-2xl border border-white/10 bg-gradient-to-br from-slate-900 to-slate-950 p-8">
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition glow">
                        </div>
                        <div class="relative z-10 space-y-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center">
                                <span class="text-2xl">💪</span>
                            </div>
                            <h3 class="text-2xl font-semibold">Entrenamiento Personalizado</h3>
                            <p class="text-slate-400">
                                Rutinas basadas en tu nivel, movilidad, fuerza y objetivo. Progresion real cada semana.
                            </p>
                            <ul class="text-sm text-slate-300 space-y-2">
                                <li>✓ Analisis inicial completo</li>
                                <li>✓ Programacion por fases</li>
                                <li>✓ Ajustes semanales</li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="group relative rounded-2xl border border-white/10 bg-gradient-to-br from-slate-900 to-slate-950 p-8">
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition glow">
                        </div>
                        <div class="relative z-10 space-y-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center">
                                <span class="text-2xl">🥗</span>
                            </div>
                            <h3 class="text-2xl font-semibold">Nutricion Estrategica</h3>
                            <p class="text-slate-400">
                                Plan flexible con macros personalizados, recetas y educacion para sostener resultados.
                            </p>
                            <ul class="text-sm text-slate-300 space-y-2">
                                <li>✓ Calculo de calorias</li>
                                <li>✓ Guia de suplementos</li>
                                <li>✓ Ajustes por progreso</li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="group relative rounded-2xl border border-white/10 bg-gradient-to-br from-slate-900 to-slate-950 p-8">
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition glow">
                        </div>
                        <div class="relative z-10 space-y-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center">
                                <span class="text-2xl">📈</span>
                            </div>
                            <h3 class="text-2xl font-semibold">Seguimiento Cercano</h3>
                            <p class="text-slate-400">
                                Medimos avances, corregimos tecnica y mantenemos motivacion con contacto directo.
                            </p>
                            <ul class="text-sm text-slate-300 space-y-2">
                                <li>✓ Check-ins semanales</li>
                                <li>✓ Evaluacion visual</li>
                                <li>✓ Soporte continuo</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- METODOLOGIA -->
        <section class="py-20 bg-slate-900/60">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <p class="text-sm uppercase tracking-[0.3em] text-blue-300">Metodologia</p>
                    <h2 class="text-4xl md:text-5xl font-display">Tres pasos, cero improvisacion.</h2>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="rounded-2xl border border-white/10 bg-slate-950/80 p-8">
                        <p class="text-blue-300 text-sm font-semibold">01</p>
                        <h3 class="text-2xl font-semibold mt-3">Diagnostico preciso</h3>
                        <p class="text-slate-400 mt-3">
                            Evaluacion de fuerza, habitos, movilidad y agenda para construir una base realista.
                        </p>
                        <div class="mt-6 text-sm text-slate-300">✓ Evaluacion completa</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-slate-950/80 p-8">
                        <p class="text-blue-300 text-sm font-semibold">02</p>
                        <h3 class="text-2xl font-semibold mt-3">Ejecucion con foco</h3>
                        <p class="text-slate-400 mt-3">
                            Plan semanal con objetivos concretos y seguimiento para sostener disciplina.
                        </p>
                        <div class="mt-6 text-sm text-slate-300">✓ Progresion guiada</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-slate-950/80 p-8">
                        <p class="text-blue-300 text-sm font-semibold">03</p>
                        <h3 class="text-2xl font-semibold mt-3">Resultados sostenibles</h3>
                        <p class="text-slate-400 mt-3">
                            Ajustes estrategicos para que el progreso sea permanente, no temporal.
                        </p>
                        <div class="mt-6 text-sm text-slate-300">✓ Habitos duraderos</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TESTIMONIOS -->
        <section class="py-20 bg-slate-950">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-blue-300">Testimonios</p>
                        <h2 class="text-4xl md:text-5xl font-display">Resultados reales, personas reales.</h2>
                    </div>
                    <p class="text-slate-400 max-w-xl">
                        Cada historia es distinta, pero el sistema es el mismo: plan, ejecucion y ajustes.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-7">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 rounded-full bg-blue-600/30 flex items-center justify-center text-sm">
                                AM</div>
                            <div>
                                <p class="font-semibold">Ana Morales</p>
                                <p class="text-xs text-slate-500">-10 kg en 16 semanas</p>
                            </div>
                        </div>
                        <p class="text-slate-300">
                            "Me dio estructura y claridad. Ahora se exactamente que hacer cada semana."
                        </p>
                        <div class="mt-4 text-blue-300 text-sm">★★★★★</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-7">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 rounded-full bg-blue-600/30 flex items-center justify-center text-sm">
                                JL</div>
                            <div>
                                <p class="font-semibold">Javier Luna</p>
                                <p class="text-xs text-slate-500">+4 kg de musculo</p>
                            </div>
                        </div>
                        <p class="text-slate-300">
                            "Mejoro mi fuerza y mi energia. El seguimiento fue clave para no abandonar."
                        </p>
                        <div class="mt-4 text-blue-300 text-sm">★★★★★</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-7">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 rounded-full bg-blue-600/30 flex items-center justify-center text-sm">
                                SR</div>
                            <div>
                                <p class="font-semibold">Sofia Ruiz</p>
                                <p class="text-xs text-slate-500">-6% grasa corporal</p>
                            </div>
                        </div>
                        <p class="text-slate-300">
                            "Nunca habia sentido tantos resultados sin matarme. Plan claro y realista."
                        </p>
                        <div class="mt-4 text-blue-300 text-sm">★★★★★</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA FUERTE -->
        <section class="py-20 bg-gradient-to-r from-slate-900 via-slate-950 to-blue-900">
            <div class="max-w-5xl mx-auto px-6">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-12 text-center">
                    <h2 class="text-4xl md:text-5xl font-display mb-4">Tu cuerpo no cambia solo. Tu estrategia si.</h2>
                    <p class="text-slate-300 text-lg mb-8">
                        Agenda una evaluacion inicial y recibe un plan claro de los proximos 90 dias.
                    </p>
                    <a href="#formulario"
                        class="inline-flex items-center justify-center bg-blue-600 text-white px-10 py-4 rounded-xl font-semibold hover:bg-blue-500 transition shadow-lg shadow-blue-600/30">
                        Quiero mi evaluacion
                    </a>
                </div>
            </div>
        </section>

        <!-- FORMULARIO -->
        <section id="formulario" class="py-20 bg-slate-950">
            <div class="max-w-3xl mx-auto px-6">
                <div class="text-center mb-12">
                    <p class="text-sm uppercase tracking-[0.3em] text-blue-300">Formulario</p>
                    <h2 class="text-4xl md:text-5xl font-display">Cuenta tu objetivo.</h2>
                    <p class="text-slate-400 text-lg mt-3">
                        Completa el formulario y te contactare en menos de 24 horas.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-6 bg-white/5 border border-white/10 p-8 rounded-2xl">
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Nombre completo</label>
                        <input v-model="form.name" type="text" placeholder="Juan Perez"
                            class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Correo electronico</label>
                        <input v-model="form.email" type="email" placeholder="tu@email.com"
                            class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Telefono</label>
                        <input v-model="form.phone" type="text" placeholder="+34 123 456 789"
                            class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Cual es tu meta
                            principal?</label>
                        <input v-model="form.goal" type="text"
                            placeholder="Ej: Perder grasa, ganar musculo, mejorar fuerza"
                            class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Mensaje (opcional)</label>
                        <textarea v-model="form.message"
                            placeholder="Cuéntame sobre tu situación actual, lesiones, limitaciones, etc." rows="5"
                            class="w-full border border-white/10 bg-slate-950/60 text-white rounded-lg p-3 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition resize-none"></textarea>
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="w-full bg-blue-600 text-white py-4 rounded-xl font-semibold text-lg hover:bg-blue-500 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ form.processing ? 'Enviando...' : 'Enviar solicitud' }}
                    </button>
                </form>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-slate-950 text-slate-500 py-10 border-t border-white/5">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <p>&copy; 2026 Metodo Blister. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</template>

<style scoped>

:global(body) {
    font-family: 'Manrope', sans-serif;
}

.font-display {
    font-family: 'Oswald', sans-serif;
}

.hero-grid {
    background-image: radial-gradient(circle at 1px 1px, rgba(148, 163, 184, 0.18) 1px, transparent 0);
    background-size: 24px 24px;
    mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), transparent 70%);
}

.glow {
    background: radial-gradient(circle at top left, rgba(59, 130, 246, 0.25), transparent 60%);
}

@keyframes rise {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-rise {
    animation: rise 0.9s ease forwards;
}
</style>

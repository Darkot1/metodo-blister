<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PlanInfoCard from '@/Components/Entrenamiento/PlanInfoCard.vue';
import SesionForm from '@/Components/Entrenamiento/SesionForm.vue';
import SesionesList from '@/Components/Entrenamiento/SesionesList.vue';
import { ChevronLeftIcon } from '@heroicons/vue/24/outline';
import { useSesionesPlan } from '@/Composables/useSesionesPlan';

const props = defineProps({
    plan: {
        type: Object,
        required: true
    }
})

const { form, sesionesCount, canAddSession, isDayAlreadyUsed, submitForm } = useSesionesPlan(props.plan);

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <AppLayout title="Agregar Sesiones de Entrenamiento">
        <div class="-m-8 min-h-full p-8">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <button @click="goBack" class="text-slate-400 hover:text-white transition-colors">
                    <ChevronLeftIcon class="w-6 h-6" />
                </button>
                <div>
                    <p class="text-m uppercase tracking-[0.3em] text-blue-300">Plan</p>
                    <h2 class="text-4xl font-display text-white">Agregar Sesiones - {{ props.plan.nombre }}</h2>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">

                <!-- Columna izquierda - Información del Plan -->
                <div class="lg:col-span-1 space-y-6">
                    <PlanInfoCard :plan="props.plan" />
                    <SesionesList :plan="props.plan" />
                </div>

                <!-- Columna derecha - Formulario -->
                <div class="lg:col-span-2">
                    <SesionForm :plan="props.plan" :form="form" :sesionesCount="sesionesCount"
                        :canAddSession="canAddSession" :isDayAlreadyUsed="isDayAlreadyUsed" @submit="submitForm"
                        @go-back="goBack" />
                </div>

            </div>

        </div>
    </AppLayout>
</template>

<style scoped>
.font-display {
    font-family: 'Oswald', sans-serif;
}
</style>

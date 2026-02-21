import { computed, reactive } from "vue";
import { useForm } from "@inertiajs/vue3";

export function useSesionesPlan(plan) {
    const form = useForm({
        nombre: "",
        dia_semana: "",
        numero_semana: 1,
    });

    const sesionesCount = computed(() => {
        if (!plan?.sesiones || !Array.isArray(plan.sesiones)) {
            return 0;
        }
        const semanaActual = plan.sesiones.filter(
            (s) => s.numero_semana === form.numero_semana,
        );
        return semanaActual.length;
    });

    const canAddSession = computed(() => {
        const maxSesiones = plan?.frecuencia_semanal || 0;
        const sesiones = sesionesCount.value;
        return sesiones < maxSesiones;
    });

    const isDayAlreadyUsed = computed(() => {
        if (!plan?.sesiones || !Array.isArray(plan.sesiones)) {
            return false;
        }
        return plan.sesiones.some(
            (s) =>
                s.numero_semana === form.numero_semana &&
                s.dia_semana === form.dia_semana,
        );
    });

    const submitForm = () => {
        if (!form.nombre || !form.dia_semana) {
            alert("Por favor completa todos los campos.");
            return;
        }

        if (!canAddSession.value) {
            alert(
                `Ya has alcanzado el máximo de ${plan.frecuencia_semanal} sesiones para la semana ${form.numero_semana}.`,
            );
            return;
        }

        if (isDayAlreadyUsed.value) {
            alert(
                `Ya existe una sesión para el ${form.dia_semana} en la semana ${form.numero_semana}.`,
            );
            return;
        }

        form.post(route("sesiones-entrenamiento.store", plan.id), {
            onSuccess: () => {
                form.nombre = "";
                form.dia_semana = "";
            },
        });
    };

    return {
        form,
        sesionesCount,
        canAddSession,
        isDayAlreadyUsed,
        submitForm,
    };
}

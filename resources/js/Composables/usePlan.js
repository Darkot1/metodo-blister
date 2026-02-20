export const usePlan = () => {
    const getFrequencia = (freq) => {
        return freq === 1 ? "1 día" : `${freq} días`;
    };

    const formatearFecha = (fecha, formato = "corto") => {
        if (!fecha) return "—";

        const opciones =
            formato === "largo"
                ? {
                      year: "numeric",
                      month: "long",
                      day: "numeric",
                  }
                : {
                      year: "numeric",
                      month: "short",
                      day: "numeric",
                  };

        return new Date(fecha).toLocaleDateString("es-ES", opciones);
    };

    const calcularDuracion = (inicio, fin) => {
        if (!inicio || !fin) return "—";
        const fechaInicio = new Date(inicio);
        const fechaFin = new Date(fin);
        const dias = Math.ceil(
            (fechaFin - fechaInicio) / (1000 * 60 * 60 * 24),
        );
        const semanas = Math.ceil(dias / 7);
        return semanas === 1 ? "1 semana" : `${semanas} semanas`;
    };

    const toDateInput = (value) => {
        if (!value) return "";
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return "";
        return date.toISOString().slice(0, 10);
    };

    return {
        getFrequencia,
        formatearFecha,
        calcularDuracion,
        toDateInput,
    };
};

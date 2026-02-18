<script setup>

import FormCheckbox from '@/Components/Form/FormCheckbox.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head title="Log in" />
    <div class="min-h-screen bg-slate-950 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-32 h-96 w-96 rounded-full bg-blue-600/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-32 h-96 w-96 rounded-full bg-cyan-500/20 blur-3xl"></div>
        </div>

        <div class="relative z-10 flex min-h-screen items-center justify-center px-6 py-12">
            <div
                class="w-full max-w-md rounded-2xl border border-white/10 bg-white/5 p-6 shadow-2xl shadow-blue-900/30">
                <div class="mb-6 flex items-center gap-3">
                    <div>
                        <p class="text-s uppercase tracking-[0.3em] text-blue-300">Acceso</p>
                        <h1 class="text-3xl font-display">Iniciar sesion</h1>
                    </div>
                </div>

                <p class="text-sm text-slate-300">
                    Ingresa con tu correo y contrasena para continuar.
                </p>

                <div v-if="status"
                    class="mt-4 rounded-lg border border-green-500/30 bg-green-500/10 px-3 py-2 text-sm text-green-200">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="mt-6 space-y-4">
                    <FormInput id="email" v-model="form.email" label="Correo electronico" type="email" required
                        autofocus autocomplete="username" :error="form.errors.email" />

                    <FormInput id="password" v-model="form.password" label="Contrasena" type="password" required
                        autocomplete="current-password" :error="form.errors.password" />

                    <div class="flex items-center justify-between">
                        <FormCheckbox v-model="form.remember" name="remember" label="Recordarme" />
                        <Link v-if="canResetPassword" :href="route('password.request')"
                            class="text-sm text-blue-300 hover:text-white transition">
                            Olvidaste tu contrasena?
                        </Link>
                    </div>

                    <button type="submit"
                        class="w-full rounded-xl bg-blue-600 py-3 font-semibold shadow-lg shadow-blue-600/30 hover:bg-blue-500"
                        :class="{ 'opacity-50 cursor-not-allowed': form.processing }" :disabled="form.processing">
                        {{ form.processing ? 'Ingresando...' : 'Iniciar sesion' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

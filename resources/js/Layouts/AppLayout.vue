<script setup>
import { ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { XMarkIcon, Bars3Icon, ChartBarIcon, UserGroupIcon, Cog6ToothIcon, ArrowLeftOnRectangleIcon, HomeIcon } from '@heroicons/vue/24/outline';

defineProps({
    title: String,
});

const { props } = usePage();
const user = props.auth?.user;
const isSidebarOpen = ref(true);

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="flex min-h-screen bg-slate-950 text-gray-900 font-sans overflow-x-hidden">

        <Head :title="title" />

        <!-- Sidebar -->
        <aside :class="[
            'flex-shrink-0 transition-all duration-300 ease-in-out bg-gradient-to-b from-gray-900 to-gray-800 border-r border-gray-700 flex flex-col h-screen fixed left-0 top-0',
            isSidebarOpen ? 'w-64' : 'w-20'
        ]">
            <!-- Logo -->
            <div class="flex items-center justify-between p-6 border-b border-gray-700 h-24">
                <div v-if="isSidebarOpen" class="flex items-center gap-3 flex-1 min-w-0">
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex-shrink-0">
                        <span class="text-white font-bold text-lg">MB</span>
                    </div>
                    <span class="text-white font-bold text-lg truncate">Método Blister</span>
                </div>
                <button @click="isSidebarOpen = !isSidebarOpen"
                    class="text-blue-400 hover:text-blue-300 transition-colors p-1 flex-shrink-0">
                    <XMarkIcon v-if="isSidebarOpen" class="h-5 w-5" />
                    <Bars3Icon v-else class="h-5 w-5" />
                </button>
            </div>

            <!-- Navegación -->
            <nav class="flex-1 p-4 space-y-6 overflow-y-auto">

                <!-- Sección Dashboard -->
                <div>
                    <p v-if="isSidebarOpen"
                        class="text-xs uppercase tracking-wider text-gray-500 font-semibold px-3 mb-3">
                        Principal
                    </p>
                    <Link :href="route('dashboard')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors"
                        :class="{ 'bg-blue-600 text-white': route().current('dashboard') }">
                        <ChartBarIcon class="w-5 h-5 flex-shrink-0" />
                        <span v-if="isSidebarOpen" class="text-sm">Dashboard</span>
                    </Link>
                </div>

                <!-- Sección Gestión Alumnos -->
                <div>
                    <p v-if="isSidebarOpen"
                        class="text-xs uppercase tracking-wider text-gray-500 font-semibold px-3 mb-3">
                        Gestión Alumnos
                    </p>
                    <Link :href="route('alumnos.index')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors"
                        :class="{ 'bg-blue-600 text-white': route().current('alumnos.index') }">
                        <UserGroupIcon class="w-5 h-5 flex-shrink-0" />
                        <span v-if="isSidebarOpen" class="text-sm">Alumnos</span>
                    </Link>

                    <Link :href="route('ejercicios.index')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors"
                        :class="{ 'bg-blue-600 text-white': route().current('ejercicios.index') }">
                        <UserGroupIcon class="w-5 h-5 flex-shrink-0" />
                        <span v-if="isSidebarOpen" class="text-sm">Ejercicios</span>
                    </Link>
                </div>

                <!-- Sección Entrenamiento -->
                <div>
                    <p v-if="isSidebarOpen"
                        class="text-xs uppercase tracking-wider text-gray-500 font-semibold px-3 mb-3">
                        Entrenamiento
                    </p>
                    <Link :href="route('planes-entrenamiento.index')"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors"
                        :class="{ 'bg-blue-600 text-white': route().current('planes-entrenamiento.*') }">
                        <ChartBarIcon class="w-5 h-5 flex-shrink-0" />
                        <span v-if="isSidebarOpen" class="text-sm">Planes</span>
                    </Link>
                </div>

            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-700 space-y-4">
                <div v-if="isSidebarOpen" class="text-xs text-gray-400 px-1">
                    <p class="font-semibold text-gray-300 mb-1 truncate">{{ user?.name }}</p>
                    <p class="text-gray-500 truncate">{{ user?.email }}</p>
                </div>
                <Link v-if="isSidebarOpen" :href="route('profile.show')"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors"
                    :class="{ 'bg-blue-600 text-white': route().current('profile.*') }">
                    <Cog6ToothIcon class="w-5 h-5 flex-shrink-0" />
                    <span class="text-sm">Configuración</span>
                </Link>
                <button type="button"
                    class="w-full flex items-center gap-3 text-blue-400 hover:text-blue-300 transition-colors text-sm py-2 px-3 rounded-lg hover:bg-gray-700"
                    @click="logout">
                    <ArrowLeftOnRectangleIcon class="w-5 h-5 flex-shrink-0" />
                    <span v-if="isSidebarOpen" class="text-sm">Cerrar sesión</span>
                </button>
            </div>
        </aside>

        <!-- Contenido principal -->
        <div :class="[
            'flex-1 flex flex-col min-h-screen min-w-0 transition-all duration-300',
            isSidebarOpen ? 'ml-64' : 'ml-20'
        ]">
            <!-- Navbar -->
            <header class="h-16 bg-slate-900 border-b border-white/10 flex items-center justify-between px-8">
                <h1 class="text-2xl font-bold text-white">
                    {{ title || 'Método Blister' }}
                </h1>
                <a href="/" class="text-slate-400 hover:text-white transition-colors" aria-label="Ir a inicio">
                    <HomeIcon class="w-6 h-6" />
                </a>
            </header>

            <!-- Contenido dinámico -->
            <main class="flex-1 overflow-y-auto p-8 bg-slate-950 min-w-0">
                <slot />
            </main>
        </div>
    </div>
</template>


<style scoped>
.font-display {
    font-family: 'Oswald', sans-serif;
}

::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-thumb {
    background: rgba(59, 130, 246, 0.5);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(59, 130, 246, 0.8);
}
</style>

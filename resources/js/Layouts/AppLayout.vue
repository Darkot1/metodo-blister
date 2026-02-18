<script setup>
import { ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';


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
    <div class="flex min-h-screen bg-gray-50 text-gray-900 font-sans overflow-x-hidden">

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
                    <svg v-if="isSidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
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
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4v4" />
                        </svg>
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
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                        <span v-if="isSidebarOpen" class="text-sm">Alumnos</span>
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
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-sm">Configuración</span>
                </Link>
                <button type="button"
                    class="w-full flex items-center gap-3 text-blue-400 hover:text-blue-300 transition-colors text-sm py-2 px-3 rounded-lg hover:bg-gray-700"
                    @click="logout">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
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
            <header class="h-16 bg-slate-950/90 border-b border-white/10 flex items-center justify-between px-8">
                <h1 class="text-2xl font-bold text-white">
                    {{ title || 'Método Blister' }}
                </h1>
                <a href="/" class="text-slate-400 hover:text-white transition-colors" aria-label="Ir a inicio">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
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

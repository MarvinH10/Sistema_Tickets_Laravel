<script setup>
import { ref, onMounted } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faTachometerAlt,
    faCity,
    faUsers,
    faTicket,
    faChalkboard,
    faBuilding,
    faChevronDown,
    faChevronUp,
    faUserShield,
    faUserGraduate,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(
    faTachometerAlt,
    faCity,
    faUsers,
    faTicket,
    faChalkboard,
    faBuilding,
    faChevronDown,
    faChevronUp,
    faUserShield,
    faUserGraduate
);

const abrirSidebar = ref(true);
const mostrarTextoSidebar = ref(true);
const abrirDropdown = ref(false);
const abrirDropdownUsuarios = ref(false);

const interactuarSidebar = () => {
    abrirSidebar.value = !abrirSidebar.value;
    localStorage.setItem("sidebarAbierto", abrirSidebar.value);

    if (abrirSidebar.value) {
        setTimeout(() => {
            mostrarTextoSidebar.value = true;
        }, 190);
    } else {
        mostrarTextoSidebar.value = false;
    }
};

const interactuarDropdown = () => {
    abrirDropdown.value = !abrirDropdown.value;
};

const interactuarDropdownUsuarios = () => {
    abrirDropdownUsuarios.value = !abrirDropdownUsuarios.value;
};

const logout = () => {
    router.post(route("logout"));
};

onMounted(() => {
    const sidebarEstado = localStorage.getItem("sidebarAbierto");
    if (sidebarEstado !== null) {
        abrirSidebar.value = JSON.parse(sidebarEstado);
        mostrarTextoSidebar.value = abrirSidebar.value;
    }
});

defineProps({
    title: String,
});
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />
        <div class="flex min-h-screen bg-gray-100">
            <nav
                class="transition-all duration-500 ease-in-out bg-white border-r shadow-md"
                :class="abrirSidebar ? 'w-60' : 'w-20'"
                style="transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1);"
            >
                <div class="w-full py-4">
                    <div class="flex items-center justify-center mb-6">
                        <Link :href="route('dashboard')">
                            <ApplicationMark class="block w-auto h-8" />
                        </Link>
                    </div>

                    <div class="flex flex-col">
                        <NavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                            class="flex items-center w-full h-12 px-4 space-x-2 transition-colors duration-300"
                            :class="{
                                'bg-blue-50 text-blue-600 border-l-4 border-blue-600':
                                    route().current('dashboard'),
                                'text-gray-600 hover:bg-gray-100':
                                    !route().current('dashboard'),
                                'justify-center': !abrirSidebar,
                            }"
                        >
                            <font-awesome-icon
                                icon="tachometer-alt"
                                class="text-lg"
                            />
                            <span v-if="mostrarTextoSidebar" class="ml-2"
                                >Dashboard</span
                            >
                        </NavLink>

                        <NavLink
                            :href="route('sede')"
                            :active="route().current('sede')"
                            class="flex items-center w-full h-12 px-4 space-x-2 transition-colors duration-300"
                            :class="{
                                'bg-blue-50 text-blue-600 border-l-4 border-blue-600':
                                    route().current('sede'),
                                'text-gray-600 hover:bg-gray-100':
                                    !route().current('sede'),
                                'justify-center': !abrirSidebar,
                            }"
                        >
                            <font-awesome-icon icon="city" class="text-lg" />
                            <span v-if="mostrarTextoSidebar" class="ml-2"
                                >Sedes</span
                            >
                        </NavLink>

                        <div>
                            <button
                                @click="interactuarDropdownUsuarios"
                                class="flex items-center w-full h-12 px-4 space-x-2 text-sm text-gray-900 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none"
                                :class="{
                                    'justify-center': !abrirSidebar,
                                    'bg-blue-50 text-blue-600 border-l-4 border-blue-600':
                                        route().current('soporte') ||
                                        route().current('docente'),
                                    'text-gray-600 hover:bg-gray-100':
                                        !route().current('soporte') &&
                                        !route().current('docente'),
                                }"
                            >
                                <font-awesome-icon
                                    icon="users"
                                    class="text-lg"
                                />
                                <span v-if="mostrarTextoSidebar" class="ml-2"
                                    >Usuarios</span
                                >
                                <font-awesome-icon
                                    :icon="
                                        abrirDropdownUsuarios
                                            ? 'chevron-up'
                                            : 'chevron-down'
                                    "
                                    class="ml-auto mr-2 transition-transform"
                                    v-if="abrirSidebar"
                                />
                            </button>

                            <div
                                v-if="abrirDropdownUsuarios"
                                class="flex flex-col ml-6"
                                v-show="abrirSidebar"
                            >
                                <NavLink
                                    :href="route('soporte')"
                                    :active="route().current('soporte')"
                                    class="flex items-center w-full h-12 px-4 space-x-2 transition-colors duration-300"
                                    :class="{
                                        'bg-blue-50 text-blue-600 border-l-4 border-blue-600':
                                            route().current('soporte'),
                                        'text-gray-600 hover:bg-gray-100':
                                            !route().current('soporte'),
                                    }"
                                >
                                    <font-awesome-icon
                                        icon="user-shield"
                                        class="text-lg"
                                    />
                                    <span>Soportes</span>
                                </NavLink>

                                <NavLink
                                    :href="route('docente')"
                                    :active="route().current('docente')"
                                    class="flex items-center w-full h-12 px-4 space-x-2 transition-colors duration-300"
                                    :class="{
                                        'bg-blue-50 text-blue-600 border-l-4 border-blue-600':
                                            route().current('docente'),
                                        'text-gray-600 hover:bg-gray-100':
                                            !route().current('docente'),
                                    }"
                                >
                                    <font-awesome-icon
                                        icon="user-graduate"
                                        class="text-lg"
                                    />
                                    <span>Docentes</span>
                                </NavLink>
                            </div>
                        </div>

                        <NavLink
                            :href="route('ticket')"
                            :active="route().current('ticket')"
                            class="flex items-center w-full h-12 px-4 space-x-2 transition-colors duration-300"
                            :class="{
                                'bg-blue-50 text-blue-600 border-l-4 border-blue-600':
                                    route().current('ticket'),
                                'text-gray-600 hover:bg-gray-100':
                                    !route().current('ticket'),
                                'justify-center': !abrirSidebar,
                            }"
                        >
                            <font-awesome-icon icon="ticket" class="text-lg" />
                            <span v-if="mostrarTextoSidebar" class="ml-2"
                                >Tickets</span
                            >
                        </NavLink>

                        <NavLink
                            :href="route('aula')"
                            :active="route().current('aula')"
                            class="flex items-center w-full h-12 px-4 space-x-2 transition-colors duration-300"
                            :class="{
                                'bg-blue-50 text-blue-600 border-l-4 border-blue-600':
                                    route().current('aula'),
                                'text-gray-600 hover:bg-gray-100':
                                    !route().current('aula'),
                                'justify-center': !abrirSidebar,
                            }"
                        >
                            <font-awesome-icon
                                icon="chalkboard"
                                class="text-lg"
                            />
                            <span v-if="mostrarTextoSidebar" class="ml-2"
                                >Aulas</span
                            >
                        </NavLink>

                        <NavLink
                            :href="route('pabellon')"
                            :active="route().current('pabellon')"
                            class="flex items-center w-full h-12 px-4 space-x-2 transition-colors duration-300"
                            :class="{
                                'bg-blue-50 text-blue-600 border-l-4 border-blue-600':
                                    route().current('pabellon'),
                                'text-gray-600 hover:bg-gray-100':
                                    !route().current('pabellon'),
                                'justify-center': !abrirSidebar,
                            }"
                        >
                            <font-awesome-icon
                                icon="building"
                                class="text-lg"
                            />
                            <span v-if="mostrarTextoSidebar" class="ml-2"
                                >Pabellones</span
                            >
                        </NavLink>
                    </div>
                </div>
            </nav>

            <div class="flex flex-col flex-1">
                <nav class="bg-white border-b border-gray-100">
                    <div
                        class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8"
                    >
                        <button
                            @click="interactuarSidebar"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    v-if="abrirSidebar"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                                <path
                                    v-else
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                        </button>

                        <div class="relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        @click="interactuarDropdown"
                                        class="flex items-center text-sm transition border-2 border-transparent rounded-full focus:outline-none"
                                    >
                                        <img
                                            class="w-8 h-8 rounded-full"
                                            :src="
                                                $page.props.auth.user
                                                    .profile_photo_url
                                            "
                                            :alt="$page.props.auth.user.name"
                                        />
                                        <span class="hidden ml-2 lg:block">{{
                                            $page.props.auth.user.name
                                        }}</span>
                                        <font-awesome-icon
                                            icon="chevron-down"
                                            class="ml-2 text-gray-600"
                                        />
                                    </button>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.show')"
                                        >Perfil</DropdownLink
                                    >
                                    <DropdownLink
                                        v-if="
                                            $page.props.jetstream.hasApiFeatures
                                        "
                                        :href="route('api-tokens.index')"
                                        >API Tokens</DropdownLink
                                    >
                                    <div class="border-t border-gray-200"></div>
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button"
                                            >Cerrar sesión</DropdownLink
                                        >
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </nav>

                <header v-if="$slots.header" class="bg-white shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <main class="flex-1 p-4">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

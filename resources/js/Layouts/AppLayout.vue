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
    faUserShield,
    faUserGraduate,
    faChevronDown,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(
    faTachometerAlt,
    faCity,
    faUsers,
    faTicket,
    faChalkboard,
    faBuilding,
    faUserShield,
    faUserGraduate,
    faChevronDown
);

const abrirSidebar = ref(true);
const mostrarTextoSidebar = ref(true);
const abrirDropdown = ref(false);

const interactuarSidebar = () => {
    abrirSidebar.value = !abrirSidebar.value;
    localStorage.setItem("sidebarAbierto", abrirSidebar.value);
    mostrarTextoSidebar.value = abrirSidebar.value;
};

const interactuarDropdown = () => (abrirDropdown.value = !abrirDropdown.value);

const logout = () => router.post(route("logout"));

const linkClasses = (isActive) => [
    "flex items-center h-12 px-4 space-x-2 transition-colors duration-300",
    abrirSidebar.value
        ? isActive
            ? "w-40 bg-gradient-to-r from-[#2EBAA1] to-green-400 text-white border-[#2EBAA1] rounded-r-full"
            : "w-40 text-white hover:border-l-4"
        : isActive
        ? "w-full bg-gradient-to-r from-[#2EBAA1] to-green-400 text-white"
        : "w-full text-white hover:border-l-4",
    { "justify-center": !abrirSidebar.value },
];

onMounted(() => {
    const sidebarEstado = localStorage.getItem("sidebarAbierto");
    if (sidebarEstado !== null) {
        abrirSidebar.value = JSON.parse(sidebarEstado);
        mostrarTextoSidebar.value = abrirSidebar.value;
    }
});

defineProps({ title: String });
</script>

<template>
    <div>
        <Head :title="title" />
        <Banner />
        <div class="flex min-h-screen bg-white">
            <nav
                class="transition-all duration-150 ease-in-out bg-[#222D32] shadow-md"
                :class="abrirSidebar ? 'w-48' : 'w-20'"
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
                            :class="linkClasses(route().current('dashboard'))"
                        >
                            <font-awesome-icon
                                icon="tachometer-alt"
                                class="text-lg"
                            />
                            <span v-if="abrirSidebar" class="ml-2"
                                >Dashboard</span
                            >
                        </NavLink>

                        <NavLink
                            :href="route('sede')"
                            :active="route().current('sede')"
                            :class="linkClasses(route().current('sede'))"
                        >
                            <font-awesome-icon icon="city" class="text-lg" />
                            <span v-if="abrirSidebar" class="ml-2">Sedes</span>
                        </NavLink>

                        <NavLink
                            :href="route('soporte')"
                            :active="route().current('soporte')"
                            :class="linkClasses(route().current('soporte'))"
                        >
                            <font-awesome-icon
                                icon="user-shield"
                                class="text-lg"
                            />
                            <span v-if="abrirSidebar" class="ml-2"
                                >Soportes</span
                            >
                        </NavLink>

                        <NavLink
                            :href="route('docente')"
                            :active="route().current('docente')"
                            :class="linkClasses(route().current('docente'))"
                        >
                            <font-awesome-icon
                                icon="user-graduate"
                                class="text-lg"
                            />
                            <span v-if="abrirSidebar" class="ml-2"
                                >Docentes</span
                            >
                        </NavLink>

                        <NavLink
                            :href="route('ticket')"
                            :active="route().current('ticket')"
                            :class="linkClasses(route().current('ticket'))"
                        >
                            <font-awesome-icon icon="ticket" class="text-lg" />
                            <span v-if="abrirSidebar" class="ml-2"
                                >Tickets</span
                            >
                        </NavLink>

                        <NavLink
                            :href="route('aula')"
                            :active="route().current('aula')"
                            :class="linkClasses(route().current('aula'))"
                        >
                            <font-awesome-icon
                                icon="chalkboard"
                                class="text-lg"
                            />
                            <span v-if="abrirSidebar" class="ml-2">Aulas</span>
                        </NavLink>

                        <NavLink
                            :href="route('pabellon')"
                            :active="route().current('pabellon')"
                            :class="linkClasses(route().current('pabellon'))"
                        >
                            <font-awesome-icon
                                icon="building"
                                class="text-lg"
                            />
                            <span v-if="abrirSidebar" class="ml-2"
                                >Pabellones</span
                            >
                        </NavLink>
                    </div>
                </div>
            </nav>

            <div class="flex flex-col flex-1">
                <nav class="bg-[#2EBAA1] border-b border-[#2EBAA1]">
                    <div
                        class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8"
                    >
                        <button
                            @click="interactuarSidebar"
                            class="text-white focus:outline-none"
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
                                    <span
                                        class="hidden ml-2 font-semibold text-white lg:block"
                                        >{{ $page.props.auth.user.name }}</span
                                    >
                                    <font-awesome-icon
                                        icon="chevron-down"
                                        class="ml-2 text-white"
                                    />
                                </button>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('profile.show')"
                                    >Perfil</DropdownLink
                                >
                                <DropdownLink
                                    v-if="$page.props.jetstream.hasApiFeatures"
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

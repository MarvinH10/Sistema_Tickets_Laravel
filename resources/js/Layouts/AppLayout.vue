<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faTicketSimple,
    faTicket,
    faUser,
    faTachometerAlt,
    faChevronDown,
    faChevronUp,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faTicketSimple,faTicket,faUser,faTachometerAlt, faChevronDown, faChevronUp);

const abrirSidebar = ref(true);
const mostrarTextoSidebar = ref(true);
const abrirDropdown = ref(false);

const interactuarSidebar = () => {
    abrirSidebar.value = !abrirSidebar.value;

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

const logout = () => {
    router.post(route("logout"));
};

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
                class="transition-all duration-[500ms] ease-in-out bg-white border-r border-gray-100"
                :class="abrirSidebar ? 'w-40' : 'w-16'"
            >
                <div class="w-full py-4">
                    <div class="flex items-center justify-center mb-4 shrink-0">
                        <Link :href="route('dashboard')">
                            <ApplicationMark class="block w-auto h-8" />
                        </Link>
                    </div>
                    <div class="flex flex-col">
                        <NavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                            class="flex items-center w-full h-12 px-4 space-x-2"
                            :class="{
                                'bg-gray-200 text-gray-800 border-none':
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
                            <span v-if="mostrarTextoSidebar">Dashboard</span>
                        </NavLink>
                        <NavLink
                            :href="route('ticket')"
                            :active="route().current('ticket')"
                            class="flex items-center w-full h-12 px-4 space-x-2"
                            :class="{
                                'bg-gray-200 text-gray-800 border-none':
                                    route().current('ticket'),
                                'text-gray-600 hover:bg-gray-100':
                                    !route().current('ticket'),
                                'justify-center': !abrirSidebar,
                            }"
                        >
                            <font-awesome-icon
                                icon="ticket"
                                class="text-lg"
                            />
                            <span v-if="mostrarTextoSidebar">Ticket</span>
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
                                        <span class="hidden ml-2 lg:block">
                                            {{ $page.props.auth.user.name }}
                                        </span>
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
                <main class="flex-1 p-6">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

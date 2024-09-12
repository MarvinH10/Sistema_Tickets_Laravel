<script setup>
import { ref, onMounted, computed } from "vue";
import Table from "../Table.vue";
import ModalCrear from "./Modals/ModalCrear.vue";
import ModalVer from "./Modals/ModalVer.vue";
import ModalEditar from "./Modals/ModalEditar.vue";
import ModalEliminar from "./Modals/ModalEliminar.vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import axios from "axios";

library.add(faPlus);

const sedes = ref([]);
const buscarQuery = ref("");
const mostrarModalCrear = ref(false);
const mostrarModalDetalles = ref(false);
const mostrarModalEditar = ref(false);
const mostrarModalEliminar = ref(false);
const sedeSeleccionada = ref(null);

const headers = ["N°", "Nombre", "Dirección", "Ciudad", "Teléfono", "Estado"];

const validatePhoneNumber = (telefono) => {
    const phone = telefono.toString();
    return phone.startsWith("+51") ? phone : `+51 ${phone}`;
};

const filtrarSedes = computed(() => {
    return sedes.value.filter(
        (sede) =>
            sede.sed_nombre
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase()) ||
            sede.sed_ciudad
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase()) ||
            sede.sed_direccion
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase()) ||
            sede.sed_telefono
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase())
    );
});

const fetchSedes = async () => {
    try {
        const response = await axios.get("/sedes");
        sedes.value = response.data
            .map((sede) => ({
                id: sede.id,
                sed_nombre: sede.sed_nombre,
                sed_direccion: sede.sed_direccion,
                sed_ciudad: sede.sed_ciudad,
                sed_telefono: validatePhoneNumber(sede.sed_telefono),
                sed_activo: sede.sed_activo,
            }));
    } catch (error) {
        console.error("Error al cargar las sedes:", error);
    }
};

const eliminarSede = async () => {
    if (sedeSeleccionada.value) {
        try {
            await axios.delete(`/sedes/${sedeSeleccionada.value.id}`);
            await fetchSedes();
            mostrarModalEliminar.value = false;
        } catch (error) {
            console.error("Error al eliminar la sede:", error);
        }
    }
};

const abrirCrearSedeModal = () => {
    mostrarModalCrear.value = true;
};

const cerrarCrearSedeModal = () => {
    mostrarModalCrear.value = false;
};

const abrirDetallesModal = (sede) => {
    sedeSeleccionada.value = sede;
    mostrarModalDetalles.value = true;
};

const cerrarDetallesModal = () => {
    mostrarModalDetalles.value = false;
};

const abrirEditarModal = (sede) => {
    sedeSeleccionada.value = sede;
    mostrarModalEditar.value = true;
};

const cerrarEditarModal = () => {
    mostrarModalEditar.value = false;
};

const abrirEliminarModal = (sede) => {
    sedeSeleccionada.value = sede;
    mostrarModalEliminar.value = true;
};

const cerrarEliminarModal = () => {
    mostrarModalEliminar.value = false;
};

onMounted(() => fetchSedes());
</script>

<template>
    <div class="p-6">
        <h1 class="mb-6 text-[20px] font-bold text-gray-500">Lista de Sedes</h1>

        <div class="flex items-center justify-between mb-4">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </span>
                <input type="text" v-model="buscarQuery" placeholder="Buscar..."
                    class="flex-grow pl-10 px-12 border border-gray-300 rounded-md placeholder-gray-400 focus:border-gray-400 focus:ring focus:ring-gray-400 focus:ring-opacity-5" />
            </div>

            <button @click="abrirCrearSedeModal"
                class="flex justify-center px-4 py-2.5 text-sm font-semibold text-white transition-all duration-300 bg-gradient-to-r from-[#2EBAA1] to-green-400 rounded-lg shadow-md hover:from-[#2EBAA1] hover:to-green-500 focus:outline-none focus:ring-2 focus:ring-[#2EBAA1] focus:ring-opacity-50">
                <font-awesome-icon icon="plus" class="mr-2 text-lg" />
                Nuevo
            </button>
        </div>

        <Table :headers="headers" :items="filtrarSedes" @view="abrirDetallesModal" @edit="abrirEditarModal"
            @delete="abrirEliminarModal" />

        <ModalCrear v-if="mostrarModalCrear" @cerrar="cerrarCrearSedeModal" @crear="fetchSedes" />

        <ModalVer v-if="mostrarModalDetalles" :sede="sedeSeleccionada" :mostrarModalDetalles="mostrarModalDetalles"
            @close="cerrarDetallesModal" />

        <ModalEditar v-if="mostrarModalEditar" :sede="sedeSeleccionada" :mostrarModalEditar="mostrarModalEditar"
            @cerrar="cerrarEditarModal" @update="fetchSedes" />

        <ModalEliminar v-if="mostrarModalEliminar" :sede="sedeSeleccionada" @cancelar="cerrarEliminarModal"
            @confirmar="eliminarSede" />
    </div>
</template>

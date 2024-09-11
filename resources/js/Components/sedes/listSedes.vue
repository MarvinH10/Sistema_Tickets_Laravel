<script setup>
import { ref, onMounted } from "vue";
import ModalCrear from "./Modals/ModalCrear.vue";
import ModalVer from "./Modals/ModalVer.vue";
import ModalEditar from "./Modals/ModalEditar.vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import axios from "axios";

library.add(faPlus);

const sedes = ref([]);
const mostrarModalCrearSede = ref(false);
const mostrarModalDetallesSede = ref(false);
const mostrarModalEditarSede = ref(false);
const sedeSeleccionada = ref(null);

const validatePhoneNumber = (telefono) => {
    const phone = telefono.toString();
    return phone.startsWith("+51") ? phone : `+51 ${phone}`;
};

const fetchSedes = async () => {
    try {
        const response = await axios.get("/sedes");
        sedes.value = response.data.map((sede) => ({
            id: sede.id,
            sed_nombre: sede.sed_nombre,
            sed_direccion: sede.sed_direccion,
            sed_ciudad: sede.sed_ciudad,
            sed_telefono: validatePhoneNumber(sede.sed_telefono),
        }));
    } catch (error) {
        console.error("Error al cargar las sedes:", error);
    }
};

const eliminarSede = async (id) => {
    if (confirm("¿Estás seguro de que deseas eliminar esta sede?")) {
        try {
            await axios.delete(`/sedes/${id}`);
            sedes.value = sedes.value.filter((sede) => sede.id !== id);
        } catch (error) {
            console.error("Error al eliminar la sede:", error);
        }
    }
};

const abrirCrearSedeModal = () => {
    mostrarModalCrearSede.value = true;
};

const cerrarCrearSedeModal = () => {
    mostrarModalCrearSede.value = false;
};

const abrirDetallesModal = (sede) => {
    sedeSeleccionada.value = sede;
    mostrarModalDetallesSede.value = true;
};

const cerrarDetallesModal = () => {
    mostrarModalDetallesSede.value = false;
};

const abrirEditarModal = (sede) => {
    sedeSeleccionada.value = sede;
    mostrarModalEditarSede.value = true;
};

const cerrarEditarModal = () => {
    mostrarModalEditarSede.value = false;
};

onMounted(() => {
    fetchSedes();
});
</script>

<template>
    <div class="max-w-6xl p-6 mx-auto">
        <h1 class="mb-6 text-2xl font-bold">Lista de Sedes</h1>

        <div class="flex justify-end mb-4">
            <button
                @click="abrirCrearSedeModal"
                class="flex items-center justify-center px-4 py-2 text-sm font-semibold text-white transition-all duration-300 bg-green-500 rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
            >
                <font-awesome-icon icon="plus" class="mr-2 text-lg" />
                Crear Nuevo
            </button>
        </div>

        <div class="overflow-x-auto">
            <table
                class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md"
            >
                <thead class="bg-gray-900 border-b border-gray-200">
                    <tr>
                        <th
                            class="px-4 py-3 text-sm font-medium text-left text-white"
                        >
                            Nombre
                        </th>
                        <th
                            class="px-4 py-3 text-sm font-medium text-left text-white"
                        >
                            Dirección
                        </th>
                        <th
                            class="px-4 py-3 text-sm font-medium text-left text-white"
                        >
                            Ciudad
                        </th>
                        <th
                            class="px-4 py-3 text-sm font-medium text-left text-white"
                        >
                            Teléfono
                        </th>
                        <th
                            class="px-4 py-3 text-sm font-medium text-center text-white"
                        >
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="sede in sedes"
                        :key="sede.id"
                        class="transition-colors duration-200 border-b"
                    >
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ sede.sed_nombre }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ sede.sed_direccion }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ sede.sed_ciudad }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ sede.sed_telefono }}
                        </td>
                        <td
                            class="flex items-center justify-center py-3 space-x-3"
                        >
                            <button
                                @click="abrirDetallesModal(sede)"
                                class="text-blue-500 transition duration-300 hover:text-blue-700"
                                title="Ver detalles"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                            <button
                                @click="abrirEditarModal(sede)"
                                class="text-green-500 transition duration-300 hover:text-green-700"
                                title="Editar"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                @click="eliminarSede(sede.id)"
                                class="text-red-500 transition duration-300 hover:text-red-700"
                                title="Eliminar"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ModalCrear
            v-if="mostrarModalCrearSede"
            @cerrar="cerrarCrearSedeModal"
            @crear="fetchSedes"
        />

        <ModalVer
            v-if="mostrarModalDetallesSede"
            :sede="sedeSeleccionada"
            :mostrarModalDetallesSede="mostrarModalDetallesSede"
            @close="cerrarDetallesModal"
        />

        <ModalEditar
            v-if="mostrarModalEditarSede"
            :sede="sedeSeleccionada"
            :mostrarModalEditarSede="mostrarModalEditarSede"
            @cerrar="cerrarEditarModal"
            @update="fetchSedes"
        />
    </div>
</template>

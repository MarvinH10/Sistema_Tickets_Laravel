<script setup>
import { ref, onMounted, computed } from "vue";
import ModalCrear from "./Modals/ModalCrear.vue";
import ModalVer from "./Modals/ModalVer.vue";
import ModalEditar from "./Modals/ModalEditar.vue";
import ModalEliminar from "./Modals/ModalEliminar.vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import axios from "axios";

library.add(faPlus);

const soportes = ref([]);
const buscarQuery = ref("");
const mostrarModalCrearSoporte = ref(false);
const mostrarModalDetallesSoporte = ref(false);
const mostrarModalEditarSoporte = ref(false);
const mostrarModalEliminarSoporte = ref(false);
const soporteSeleccionado = ref(null);

const validatePhoneNumber = (telefono) => {
    const phone = telefono.toString();
    return phone.startsWith("+51") ? phone : `+51 ${phone}`;
};

const filtrarSoportes = computed(() => {
    return soportes.value.filter(
        (soporte) =>
            soporte.name
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase()) ||
            soporte.email
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase()) ||
            soporte.celular
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase())
    );
});

const fetchSoportes = async () => {
    try {
        const response = await axios.get("/soportes");
        soportes.value = response.data
            .filter((soporte) => soporte.activo === 1)
            .map((soporte) => ({
                id: soporte.id,
                name: soporte.name,
                email: soporte.email,
                sed_id: soporte.sed_id,
                celular: validatePhoneNumber(soporte.celular),
                rol_nombre: soporte.rol.rol_nombre,
            }));
    } catch (error) {
        console.error("Error al cargar los soportes técnicos:", error);
    }
};

const eliminarSoporte = async () => {
    if (soporteSeleccionado.value) {
        try {
            await axios.delete(`/soportes/${soporteSeleccionado.value.id}`);
            soportes.value = soportes.value.filter(
                (soporte) => soporte.id !== soporteSeleccionado.value.id
            );
            mostrarModalEliminarSoporte.value = false;
        } catch (error) {
            console.error("Error al eliminar al soporte técnico:", error);
        }
    }
};

const abrirCrearSoporteModal = () => {
    mostrarModalCrearSoporte.value = true;
};

const cerrarCrearSoporteModal = () => {
    mostrarModalCrearSoporte.value = false;
};

const abrirDetallesModal = (soporte) => {
    soporteSeleccionado.value = soporte;
    mostrarModalDetallesSoporte.value = true;
};

const cerrarDetallesModal = () => {
    mostrarModalDetallesSoporte.value = false;
};

const abrirEditarModal = (soporte) => {
    soporteSeleccionado.value = soporte;
    mostrarModalEditarSoporte.value = true;
};

const cerrarEditarModal = () => {
    mostrarModalEditarSoporte.value = false;
};
const abrirEliminarModal = (soporte) => {
    soporteSeleccionado.value = soporte;
    mostrarModalEliminarSoporte.value = true;
};

const cerrarEliminarModal = () => {
    mostrarModalEliminarSoporte.value = false;
};

onMounted(() => {
    fetchSoportes();
});
</script>

<template>
    <div class="w-full max-w-6xl p-4 mx-auto">
        <h1 class="mb-6 text-2xl font-bold">Lista de Soportes Técnicos</h1>

        <div class="flex items-center mb-4 space-x-4">
            <input
                type="text"
                v-model="buscarQuery"
                placeholder="Buscar por nombre, correo o teléfono"
                class="flex-grow p-2 border border-gray-300 rounded-md"
            />

            <button
                @click="abrirCrearSoporteModal"
                class="flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white transition-all duration-300 bg-green-500 rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
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
                            Nombres
                        </th>
                        <th
                            class="px-4 py-3 text-sm font-medium text-left text-white"
                        >
                            Correo
                        </th>
                        <th
                            class="px-4 py-3 text-sm font-medium text-left text-white"
                        >
                            Teléfono
                        </th>
                        <th
                            class="px-4 py-3 text-sm font-medium text-left text-white"
                        >
                            Rol
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
                        v-for="soporte in filtrarSoportes"
                        :key="soporte.id"
                        class="transition-colors duration-200 border-b"
                    >
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ soporte.name }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ soporte.email }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ soporte.celular }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ soporte.rol_nombre }}
                        </td>
                        <td
                            class="flex items-center justify-center py-3 space-x-3"
                        >
                            <button
                                @click="abrirDetallesModal(soporte)"
                                class="text-blue-500 transition duration-300 hover:text-blue-700"
                                title="Ver detalles"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                            <button
                                @click="abrirEditarModal(soporte)"
                                class="text-green-500 transition duration-300 hover:text-green-700"
                                title="Editar"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                @click="abrirEliminarModal(soporte)"
                                class="text-red-500 transition duration-300 hover:text-red-700"
                                title="Eliminar"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="filtrarSoportes.length === 0">
                        <td
                            colspan="5"
                            class="px-4 py-3 text-sm text-center text-gray-500"
                        >
                            No se encontraron resultados.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ModalCrear
            v-if="mostrarModalCrearSoporte"
            @cerrar="cerrarCrearSoporteModal"
            @crear="fetchSoportes"
        />

        <ModalVer
            v-if="mostrarModalDetallesSoporte"
            :soporte="soporteSeleccionado"
            :mostrarModalDetallesSoporte="mostrarModalDetallesSoporte"
            @close="cerrarDetallesModal"
        />

        <ModalEditar
            v-if="mostrarModalEditarSoporte"
            :soporte="soporteSeleccionado"
            :mostrarModalEditarSoporte="mostrarModalEditarSoporte"
            @cerrar="cerrarEditarModal"
            @update="fetchSoportes"
        />

        <ModalEliminar
            v-if="mostrarModalEliminarSoporte"
            :soporte="soporteSeleccionado"
            @confirmar="eliminarSoporte"
            @cancelar="cerrarEliminarModal"
        />
    </div>
</template>

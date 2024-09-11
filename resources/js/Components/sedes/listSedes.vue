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

const sedes = ref([]);
const buscarQuery = ref("");
const mostrarModalCrearSede = ref(false);
const mostrarModalDetallesSede = ref(false);
const mostrarModalEditarSede = ref(false);
const mostrarModalEliminarSede = ref(false);
const sedeSeleccionada = ref(null);

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
            .filter((sede) => sede.sed_activo === 1)
            .map((sede) => ({
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

const eliminarSede = async () => {
    if (sedeSeleccionada.value) {
        try {
            await axios.delete(`/sedes/${sedeSeleccionada.value.id}`);
            sedes.value = sedes.value.filter(
                (sede) => sede.id !== sedeSeleccionada.value.id
            );
            mostrarModalEliminarSede.value = false;
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
const abrirEliminarModal = (sede) => {
    sedeSeleccionada.value = sede;
    mostrarModalEliminarSede.value = true;
};

const cerrarEliminarModal = () => {
    mostrarModalEliminarSede.value = false;
};

onMounted(() => {
    fetchSedes();
});
</script>

<template>
    <div class="w-full max-w-6xl p-4 mx-auto">
        <h1 class="mb-6 text-2xl font-bold">Lista de Sedes</h1>

        <div class="flex items-center mb-4 space-x-4">
            <input
                type="text"
                v-model="buscarQuery"
                placeholder="Buscar por nombre, dirección, ciudad o teléfono"
                class="flex-grow p-2 border border-gray-300 rounded-md"
            />

            <button
                @click="abrirCrearSedeModal"
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
                        v-for="sede in filtrarSedes"
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
                                @click="abrirEliminarModal(sede)"
                                class="text-red-500 transition duration-300 hover:text-red-700"
                                title="Eliminar"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="filtrarSedes.length === 0">
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

        <ModalEliminar
            v-if="mostrarModalEliminarSede"
            :sede="sedeSeleccionada"
            @cancelar="cerrarEliminarModal"
            @confirmar="eliminarSede"
        />
    </div>
</template>

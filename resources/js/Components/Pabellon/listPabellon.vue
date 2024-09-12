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

const pabellons = ref([]);
const buscarQuery = ref("");
const mostrarModalCrearPabellon = ref(false);
const mostrarModalDetallesPabellon = ref(false);
const mostrarModalEditarPabellon = ref(false);
const mostrarModalEliminarPabellon = ref(false);
const pabellonSeleccionado = ref(null);

const filtrarPabellones = computed(() => {
    return pabellons.value.filter(
        (pabellon) =>
            pabellon.pab_nombre
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase())
    );
});

const fetchPabellones = async () => {
    try {
        const response = await axios.get("/pabellons");
        pabellons.value = response.data
            .filter((pabellon) => pabellon.pab_activo)
            .map((pabellon) => ({
                id: pabellon.id,
                pab_nombre: pabellon.pab_nombre,
                sed_nombre: pabellon.sede.sed_nombre,
                sed_id: pabellon.sed_id,
            }));
    } catch (error) {
        console.error("Error al cargar los pabellones:", error);
    }
};

const eliminarPabellon = async () => {
    if (pabellonSeleccionado.value) {
        try {
            await axios.delete(`/pabellons/${pabellonSeleccionado.value.id}`);
            pabellons.value = pabellons.value.filter(
                (pabellon) => pabellon.id !== pabellonSeleccionado.value.id
            );
            mostrarModalEliminarPabellon.value = false;
        } catch (error) {
            console.error("Error al eliminar el pabellón:", error);
        }
    }
};

const abrirCrearPabellonModal = () => {
    mostrarModalCrearPabellon.value = true;
};

const cerrarCrearPabellonModal = () => {
    mostrarModalCrearPabellon.value = false;
};

const abrirDetallesModal = (pabellon) => {
    pabellonSeleccionado.value = pabellon;
    mostrarModalDetallesPabellon.value = true;
};

const cerrarDetallesModal = () => {
    mostrarModalDetallesPabellon.value = false;
};

const abrirEditarModal = (pabellon) => {
    pabellonSeleccionado.value = pabellon;
    mostrarModalEditarPabellon.value = true;
};

const cerrarEditarModal = () => {
    mostrarModalEditarPabellon.value = false;
};

const abrirEliminarModal = (pabellon) => {
    pabellonSeleccionado.value = pabellon;
    mostrarModalEliminarPabellon.value = true;
};

const cerrarEliminarModal = () => {
    mostrarModalEliminarPabellon.value = false;
};

onMounted(() => {
    fetchPabellones();
});
</script>

<template>
    <div class="p-6">
        <h1 class="mb-6 text-2xl font-bold">Lista de Pabellones</h1>

        <div class="flex items-center mb-4 space-x-4">
            <input
                type="text"
                v-model="buscarQuery"
                placeholder="Buscar por nombre"
                class="flex-grow p-2 border border-gray-300 rounded-md"
            />

            <button
                @click="abrirCrearPabellonModal"
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
                            Pabellones
                        </th>
                        <th
                            class="px-4 py-3 text-sm font-medium text-center text-white"
                        >
                            Sedes
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
                        v-for="pabellon in filtrarPabellones"
                        :key="pabellon.id"
                        class="transition-colors duration-200 border-b"
                    >
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ pabellon.pab_nombre }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ pabellon.sed_nombre }}
                        </td>
                        <td
                            class="flex items-center justify-center py-3 space-x-3"
                        >
                            <button
                                @click="abrirDetallesModal(pabellon)"
                                class="text-blue-500 transition duration-300 hover:text-blue-700"
                                title="Ver detalles"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                            <button
                                @click="abrirEditarModal(pabellon)"
                                class="text-green-500 transition duration-300 hover:text-green-700"
                                title="Editar"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                @click="abrirEliminarModal(pabellon)"
                                class="text-red-500 transition duration-300 hover:text-red-700"
                                title="Eliminar"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="filtrarPabellones.length === 0">
                        <td
                            colspan="2"
                            class="px-4 py-3 text-sm text-center text-gray-500"
                        >
                            No se encontraron resultados.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ModalCrear
            v-if="mostrarModalCrearPabellon"
            @cerrar="cerrarCrearPabellonModal"
            @crear="fetchPabellones"
        />

        <ModalVer
            v-if="mostrarModalDetallesPabellon"
            :pabellon="pabellonSeleccionado"
            :mostrarModalDetallesPabellon="mostrarModalDetallesPabellon"
            @close="cerrarDetallesModal"
        />

        <ModalEditar
            v-if="mostrarModalEditarPabellon"
            :pabellon="pabellonSeleccionado"
            :mostrarModalEditarPabellon="mostrarModalEditarPabellon"
            @cerrar="cerrarEditarModal"
            @update="fetchPabellones"
        />

        <ModalEliminar
            v-if="mostrarModalEliminarPabellon"
            :pabellon="pabellonSeleccionado"
            @cancelar="cerrarEliminarModal"
            @confirmar="eliminarPabellon"
        />
    </div>
</template>

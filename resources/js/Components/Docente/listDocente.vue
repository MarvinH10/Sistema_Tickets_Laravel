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

const docentes = ref([]);
const buscarQuery = ref("");
const mostrarModalCrearDocente = ref(false);
const mostrarModalDetallesDocente = ref(false);
const mostrarModalEditarDocente = ref(false);
const mostrarModalEliminarDocente = ref(false);
const docenteSeleccionado = ref(null);

const validatePhoneNumber = (telefono) => {
    const phone = telefono.toString();
    return phone.startsWith("+51") ? phone : `+51 ${phone}`;
};

const filtrarDocentes = computed(() => {
    return docentes.value.filter(
        (docente) =>
            docente.name
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase()) ||
            docente.email
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase()) ||
            docente.celular
                .toLowerCase()
                .includes(buscarQuery.value.toLowerCase())
    );
});

const fetchDocentes = async () => {
    try {
        const response = await axios.get("/docentes");
        docentes.value = response.data
            .filter((docente) => docente.activo === 1)
            .map((docente) => ({
                id: docente.id,
                name: docente.name,
                email: docente.email,
                sed_id: docente.sed_id,
                celular: validatePhoneNumber(docente.celular),
                rol_nombre: docente.rol.rol_nombre,
            }));
    } catch (error) {
        console.error("Error al cargar los docentes:", error);
    }
};

const eliminarDocente = async () => {
    if (docenteSeleccionado.value) {
        try {
            await axios.delete(`/docentes/${docenteSeleccionado.value.id}`);
            docentes.value = docentes.value.filter(
                (docente) => docente.id !== docenteSeleccionado.value.id
            );
            mostrarModalEliminarDocente.value = false;
        } catch (error) {
            console.error("Error al eliminar al docente:", error);
        }
    }
};

const abrirCrearDocenteModal = () => {
    mostrarModalCrearDocente.value = true;
};

const cerrarCrearDocenteModal = () => {
    mostrarModalCrearDocente.value = false;
};

const abrirDetallesModal = (docente) => {
    docenteSeleccionado.value = docente;
    mostrarModalDetallesDocente.value = true;
};

const cerrarDetallesModal = () => {
    mostrarModalDetallesDocente.value = false;
};

const abrirEditarModal = (docente) => {
    docenteSeleccionado.value = docente;
    mostrarModalEditarDocente.value = true;
};

const cerrarEditarModal = () => {
    mostrarModalEditarDocente.value = false;
};
const abrirEliminarModal = (docente) => {
    docenteSeleccionado.value = docente;
    mostrarModalEliminarDocente.value = true;
};

const cerrarEliminarModal = () => {
    mostrarModalEliminarDocente.value = false;
};

onMounted(() => {
    fetchDocentes();
});
</script>

<template>
<<<<<<< HEAD
    <div class="w-full max-w-6xl p-4 mx-auto">
        <h1 class="mb-6 text-2xl font-bold">Lista de Docentes</h1>
=======
    <div class="p-6">
        <h1 class="mb-4 text-2xl font-bold">Lista de Docentes</h1>
>>>>>>> ee0eb692edb8460499f5d408f011a9f37f1cfbb9

        <div class="flex items-center mb-4 space-x-4">
            <input
                type="text"
                v-model="buscarQuery"
                placeholder="Buscar por nombre, correo o teléfono"
                class="flex-grow p-2 border border-gray-300 rounded-md"
            />

            <button
                @click="abrirCrearDocenteModal"
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
                        v-for="docente in filtrarDocentes"
                        :key="docente.id"
                        class="transition-colors duration-200 border-b"
                    >
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ docente.name }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ docente.email }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ docente.celular }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ docente.rol_nombre }}
                        </td>
                        <td
                            class="flex items-center justify-center py-3 space-x-3"
                        >
                            <button
                                @click="abrirDetallesModal(docente)"
                                class="text-blue-500 transition duration-300 hover:text-blue-700"
                                title="Ver detalles"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                            <button
                                @click="abrirEditarModal(docente)"
                                class="text-green-500 transition duration-300 hover:text-green-700"
                                title="Editar"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                @click="abrirEliminarModal(docente)"
                                class="text-red-500 transition duration-300 hover:text-red-700"
                                title="Eliminar"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="filtrarDocentes.length === 0">
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
            v-if="mostrarModalCrearDocente"
            @cerrar="cerrarCrearDocenteModal"
            @crear="fetchDocentes"
        />

        <ModalVer
            v-if="mostrarModalDetallesDocente"
            :docente="docenteSeleccionado"
            :mostrarModalDetallesDocente="mostrarModalDetallesDocente"
            @close="cerrarDetallesModal"
        />

        <ModalEditar
            v-if="mostrarModalEditarDocente"
            :docente="docenteSeleccionado"
            :mostrarModalEditarDocente="mostrarModalEditarDocente"
            @cerrar="cerrarEditarModal"
            @update="fetchDocentes"
        />

        <ModalEliminar
            v-if="mostrarModalEliminarDocente"
            :docente="docenteSeleccionado"
            @confirmar="eliminarDocente"
            @cancelar="cerrarEliminarModal"
        />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import ModalCrear from "./Modals/ModalCrear.vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faPlus);

const sedes = ref([]);
const mostrarModalCrearSede = ref(false);

const validatePhoneNumber = (telefono) => {
    const phone = telefono.toString();
    return phone.startsWith("+51") ? phone : `+51 ${phone}`;
};

const fetchSedes = async () => {
    try {
        const response = await fetch("/api/sedes");
        const data = await response.json();
        sedes.value = data.map((sede) => ({
            id: sede.id,
            nombre: sede.sed_nombre,
            direccion: sede.sed_direccion,
            ciudad: sede.sed_ciudad,
            telefono: validatePhoneNumber(sede.sed_telefono),
            correo: sede.sed_correo,
        }));
    } catch (error) {
        console.error("Error al cargar las sedes:", error);
    }
};

const abrirCrearSedeModal = () => {
    mostrarModalCrearSede.value = true;
};

const cerrarCrearSedeModal = () => {
    mostrarModalCrearSede.value = false;
};

const crearSede = (nuevaSede) => {
    sedes.value.push({
        id: nuevaSede.id,
        nombre: nuevaSede.sed_nombre,
        direccion: nuevaSede.sed_direccion,
        ciudad: nuevaSede.sed_ciudad,
        telefono: validatePhoneNumber(nuevaSede.sed_telefono),
    });
    cerrarCrearSedeModal();
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
                            {{ sede.nombre }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ sede.direccion }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ sede.ciudad }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ sede.telefono }}
                        </td>
                        <td
                            class="flex items-center justify-center py-3 space-x-3"
                        >
                            <button
                                @click="showDetallesModal(sede)"
                                class="text-blue-500 transition duration-300 hover:text-blue-700"
                                title="Ver detalles"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                            <button
                                @click="showEditarModal(sede)"
                                class="text-green-500 transition duration-300 hover:text-green-700"
                                title="Editar"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ModalCrear
            v-if="mostrarModalCrearSede"
            @cerrar="cerrarCrearSedeModal"
            @crear="crearSede"
        />
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faSave, faTimes } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import axios from "axios";

library.add(faSave, faTimes);

const props = defineProps({
    sede: Object,
    mostrarModalEditarSede: Boolean,
});

const emit = defineEmits(["cerrar", "update"]);

const nuevaSede = ref({
    sed_nombre: "",
    sed_direccion: "",
    sed_ciudad: "",
    sed_telefono: "",
});

watch(
    () => props.sede,
    (newSede) => {
        if (newSede) {
            nuevaSede.value = {
                sed_nombre: newSede.sed_nombre,
                sed_direccion: newSede.sed_direccion,
                sed_ciudad: newSede.sed_ciudad,
                sed_telefono: newSede.sed_telefono,
            };
        }
    },
    { immediate: true }
);

const editarSede = async () => {
    try {
        const response = await axios.put(
            `/sedes/${props.sede.id}`,
            nuevaSede.value,
            {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            }
        );
        emit("update", response.data);
        cerrarEditarModal();
    } catch (error) {
        console.error("Error al editar la sede:", error);
        if (error.response && error.response.status === 422) {
            console.error("Errores de validación:", error.response.data.errors);
        }
    }
};

const cerrarEditarModal = () => {
    emit("cerrar");
};
</script>

<template>
    <div
        v-if="mostrarModalEditarSede"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl font-bold">Editar Sede</h2>
            <label class="block mb-2">Nombre:</label>
            <input
                type="text"
                v-model="nuevaSede.sed_nombre"
                class="w-full p-2 mb-4 border rounded"
            />
            <label class="block mb-2">Dirección:</label>
            <input
                type="text"
                v-model="nuevaSede.sed_direccion"
                class="w-full p-2 mb-4 border rounded"
            />
            <label class="block mb-2">Ciudad:</label>
            <input
                type="text"
                v-model="nuevaSede.sed_ciudad"
                class="w-full p-2 mb-4 border rounded"
            />
            <label class="block mb-2">Teléfono:</label>
            <input
                type="text"
                v-model="nuevaSede.sed_telefono"
                class="w-full p-2 mb-4 border rounded"
            />
            <div class="flex justify-end mt-6 space-x-4">
                <button
                    @click="editarSede"
                    class="flex items-center px-2 py-2 text-white transition-all duration-300 bg-green-500 rounded-lg shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="save" class="mr-2 text-lg" />
                    Actualizar
                </button>
                <button
                    @click="cerrarEditarModal"
                    class="flex items-center px-2 py-2 text-white transition-all duration-300 bg-red-500 rounded-lg shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="times" class="mr-2 text-lg" />
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

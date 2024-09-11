<script setup>
import { ref } from "vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faSave, faTimes } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import axios from "axios";

library.add(faSave, faTimes);

const emit = defineEmits(["cerrar", "crear"]);

const nuevaSede = ref({
    sed_nombre: "",
    sed_direccion: "",
    sed_ciudad: "",
    sed_telefono: "",
    sed_activo: true,
});

const errores = ref([]);

const crearSede = async () => {
    try {
        const response = await axios.post("/sedes", nuevaSede.value, {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        });
        emit("crear", response.data);

        nuevaSede.value = {
            sed_nombre: "",
            sed_direccion: "",
            sed_ciudad: "",
            sed_telefono: "",
            sed_activo: true,
        };
        errores.value = [];
        emit("cerrar");
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errores.value = error.response.data.errors;
        } else {
            console.error("Error al crear la sede:", error);
        }
    }
};

const cerrarModal = () => {
    emit("cerrar");
};
</script>

<template>
    <div
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl font-bold">Crear Nueva Sede</h2>
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
                    @click="crearSede"
                    class="flex items-center px-2 py-2 text-white transition-all duration-300 bg-green-500 rounded-lg shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="save" class="mr-2 text-lg" />
                    Crear
                </button>
                <button
                    @click="cerrarModal"
                    class="flex items-center px-2 py-2 text-white transition-all duration-300 bg-red-500 rounded-lg shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="times" class="mr-2 text-lg" />
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

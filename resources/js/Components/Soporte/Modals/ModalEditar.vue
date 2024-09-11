<script setup>
import { ref, watch, onMounted } from "vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faSave, faTimes } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import axios from "axios";

library.add(faSave, faTimes);

const props = defineProps({
    soporte: Object,
    mostrarModalEditarSoporte: Boolean,
});

const emit = defineEmits(["cerrar", "update"]);

const nuevoSoporte = ref({
    name: "",
    email: "",
    celular: "",
    sed_id: "",
    password: "",
});

const sedes = ref([]);

watch(
    () => props.soporte,
    (newSoporte) => {
        if (newSoporte) {
            nuevoSoporte.value = {
                name: newSoporte.name || "",
                email: newSoporte.email || "",
                celular: newSoporte.celular || "",
                sed_id: newSoporte.sed_id || "",
                password: "",
            };
        }
    },
    { immediate: true }
);

const fetchSedes = async () => {
    try {
        const response = await axios.get("/sedes");
        sedes.value = response.data.map((sede) => ({
            value: sede.id,
            text: sede.sed_nombre,
        }));
    } catch (error) {
        console.error("Error al cargar las sedes:", error);
    }
};

const editarSoporte = async () => {
    try {
        const response = await axios.put(
            `/soportes/${props.soporte.id}`,
            nuevoSoporte.value,
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
        console.error("Error al editar al soporte técnico:", error);
        if (error.response && error.response.status === 422) {
            console.error("Errores de validación:", error.response.data.errors);
        }
    }
};

const cerrarEditarModal = () => {
    emit("cerrar");
};

onMounted(() => {
    fetchSedes();
});
</script>

<template>
    <div
        v-if="mostrarModalEditarSoporte"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl font-bold">Editar Soporte Técnico</h2>
            <label class="block mb-2">Nombres:</label>
            <input
                type="text"
                v-model="nuevoSoporte.name"
                class="w-full p-2 mb-4 border rounded"
            />
            <label class="block mb-2">Seleccionar Sede:</label>
            <select
                v-model="nuevoSoporte.sed_id"
                class="w-full p-2 mb-4 border rounded"
            >
                <option value="" disabled>Selecciona una sede</option>
                <option
                    v-for="sede in sedes"
                    :key="sede.value"
                    :value="sede.value"
                >
                    {{ sede.text }}
                </option>
            </select>
            <label class="block mb-2">Correo:</label>
            <input
                type="text"
                v-model="nuevoSoporte.email"
                class="w-full p-2 mb-4 border rounded"
            />
            <label class="block mb-2">Teléfono:</label>
            <input
                type="text"
                v-model="nuevoSoporte.celular"
                class="w-full p-2 mb-4 border rounded"
            />
            <label class="block mb-2">Contraseña (opcional):</label>
            <input
                type="text"
                v-model="nuevoSoporte.password"
                placeholder="Dejar vacío si no deseas cambiar"
                class="w-full p-2 mb-4 border rounded"
            />
            <div class="flex justify-end mt-6 space-x-4">
                <button
                    @click="editarSoporte"
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

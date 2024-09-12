<script setup>
import { ref, watch, onMounted } from "vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faSave, faTimes } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import axios from "axios";

library.add(faSave, faTimes);

const props = defineProps({
    pabellon: Object,
    mostrarModalEditarPabellon: Boolean,
});

const emit = defineEmits(["cerrar", "update"]);
const sedes = ref([]);
const nuevoPabellon = ref({
    pab_nombre: "",
    pab_activo: true,
    sed_id:"",
});

watch(
    () => props.pabellon,
    (newPabellon) => {
        if (newPabellon) {
            nuevoPabellon.value = {
                pab_nombre: newPabellon.pab_nombre,
                pab_activo: newPabellon.pab_activo,
                sed_id: newPabellon.sed_id,
            };
        }
    },
    { immediate: true }
);

const editarPabellon = async () => {
    try {
        const response = await axios.put(
            `/pabellons/${props.pabellon.id}`,
            nuevoPabellon.value,
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
        console.error("Error al editar el pabellon:", error);
        if (error.response && error.response.status === 422) {
            console.error("Errores de validación:", error.response.data.errors);
        }
    }
};

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

const cerrarEditarModal = () => {
    emit("cerrar");
};

onMounted(() => {
    fetchSedes();
});
</script>

<template>
    <div
        v-if="mostrarModalEditarPabellon"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl font-bold">Editar Pabellón</h2>
            <label class="block mb-2">Nombre:</label>
            <input
                type="text"
                v-model="nuevoPabellon.pab_nombre"
                class="w-full p-2 mb-4 border rounded"
            />
            <label class="block mb-2">Seleccionar Sede:</label>
            <select
                v-model="nuevoPabellon.sed_id"
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
            <div class="flex justify-end mt-6 space-x-4">
                <button
                    @click="editarPabellon"
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
<script setup>
import { ref, watch } from "vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faSave, faTimes, faSpinner } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import axios from "axios";

library.add(faSave, faTimes, faSpinner);

const props = defineProps({
    item: Object,
    itemName: String,
    formFields: Array,
    mostrarModalEditar: Boolean,
    endpoint: String,
});

const emit = defineEmits(["cerrar", "update"]);

const formData = ref({});
const errores = ref([]);
const loading = ref(false);
const successMessage = ref("");

watch(
    () => props.item,
    (newItem) => {
        if (newItem) {
            formData.value = { ...newItem };
        }
    },
    { immediate: true }
);

const editarItem = async () => {
    loading.value = true;
    successMessage.value = "";
    errores.value = [];
    try {
        const response = await axios.put(
            `${props.endpoint}/${props.item.id}`,
            formData.value,
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
        cerrarModal();
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errores.value = error.response.data.errors;
        } else {
            console.error("Error:", error);
        }
    } finally {
        loading.value = false;
    }
};

const cerrarModal = () => emit("cerrar");
</script>

<template>
    <div
        v-if="mostrarModalEditar"
        class="fixed inset-0 flex items-center justify-center transition-opacity bg-black bg-opacity-50"
    >
        <div
            class="w-full max-w-lg p-6 transition-transform transform bg-white rounded-lg shadow-lg"
        >
            <h2 class="mb-4 text-xl font-bold text-gray-600">
                Editar {{ itemName }}
            </h2>
            <p v-if="successMessage" class="mb-4 text-green-500">
                {{ successMessage }}
            </p>
            <div v-for="(field, index) in formFields" :key="index" class="mb-4">
                <label :for="field.name" class="block mb-2 text-gray-500"
                    >{{ field.label }}:</label
                >
                <input
                    :id="field.name"
                    :type="field.type"
                    v-model="formData[field.name]"
                    class="flex-grow w-full p-2 mb-1 placeholder-gray-400 border border-gray-300 rounded-md focus:border-[#2EBAA1] focus:ring focus:ring-[#2EBAA1] focus:ring-opacity-50"
                />
                <p v-if="errores[field.name]" class="text-sm text-red-500">
                    {{ errores[field.name][0] }}
                </p>
            </div>
            <div class="flex justify-end mt-6 space-x-4">
                <button
                    @click="editarItem"
                    :disabled="loading"
                    class="flex justify-center items-center px-4 py-2.5 text-sm font-semibold text-white transition-all duration-300 bg-gradient-to-r from-green-300 to-[#2EBAA1] rounded-lg shadow-md hover:from-green-400 hover:to-[#2EBAA1] focus:outline-none focus:ring-2 focus:ring-[#2EBAA1] focus:ring-opacity-50"
                >
                    <font-awesome-icon
                        v-if="loading"
                        icon="spinner"
                        class="mr-2 animate-spin"
                    />
                    <font-awesome-icon
                        v-else
                        icon="save"
                        class="mr-2 text-lg"
                    />
                    Actualizar
                </button>
                <button
                    @click="cerrarModal"
                    :disabled="loading"
                    class="flex justify-center px-4 py-2.5 text-sm font-semibold text-white transition-all duration-300 bg-gradient-to-r from-gray-300 to-gray-400 rounded-lg shadow-md hover:from-gray-300 hover:to-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="times" class="mr-2 text-lg" />
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { library } from "@fortawesome/fontawesome-svg-core";
import { faTimes } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faTimes);

const props = defineProps({
    item: Object,
    itemName: String,
    formFields: Array,
    mostrarModalDetalles: Boolean,
});

const emit = defineEmits(["close"]);

const cerrarDetallesModal = () => {
    emit("close");
};
</script>

<template>
    <div
        v-if="mostrarModalDetalles"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl font-bold text-gray-600">
                Detalles {{ itemName }}
            </h2>
            <div
                v-for="(field, index) in formFields"
                :key="index"
                class="mb-2 text-gray-500"
            >
                <p>
                    <strong>{{ field.label }}:</strong>
                    {{ item[field.name] || "No disponible" }}
                </p>
            </div>
            <div class="flex justify-end mt-4">
                <button
                    @click="cerrarDetallesModal"
                    class="flex justify-center px-4 py-2.5 text-sm font-semibold text-white transition-all duration-300 bg-gradient-to-r from-gray-300 to-gray-400 rounded-lg shadow-md hover:from-gray-300 hover:to-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="times" class="mr-2 text-lg" />
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

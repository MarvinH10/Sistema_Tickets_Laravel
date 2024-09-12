<script setup>
import { library } from "@fortawesome/fontawesome-svg-core";
import { faTimes, faPowerOff } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faTimes, faPowerOff);

const props = defineProps({
    item: Object,
    itemName: String,
    fieldName: String,
});

const emit = defineEmits(["confirmar", "cancelar"]);
</script>

<template>
    <div
        class="fixed inset-0 flex items-center justify-center transition-opacity bg-black bg-opacity-50"
    >
        <div
            class="w-full max-w-lg p-6 transition-transform transform bg-white rounded-lg shadow-lg"
        >
            <h2 class="mb-4 text-xl font-bold text-gray-600">
                Desactivar {{ itemName }}
            </h2>
            <p>
                ¿Estás seguro de que deseas marcar como inactiva
                <strong>{{ item[fieldName] }}</strong
                >?
            </p>
            <p class="mt-2 text-sm text-gray-500">
                Esta acción no eliminará {{ itemName }}, solo la desactivará y
                no estará disponible para ser utilizada.
            </p>
            <div class="flex justify-end mt-6 space-x-4">
                <button
                    @click="$emit('confirmar')"
                    class="flex justify-center items-center px-4 py-2.5 text-sm font-semibold text-white transition-all duration-300 bg-gradient-to-r from-red-300 to-red-500 rounded-lg shadow-md hover:from-red-400 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="power-off" class="mr-2 text-lg" />
                    Desactivar
                </button>
                <button
                    @click="$emit('cancelar')"
                    class="flex justify-center px-4 py-2.5 text-sm font-semibold text-white transition-all duration-300 bg-gradient-to-r from-gray-300 to-gray-400 rounded-lg shadow-md hover:from-gray-300 hover:to-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="times" class="mr-2 text-lg" />
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

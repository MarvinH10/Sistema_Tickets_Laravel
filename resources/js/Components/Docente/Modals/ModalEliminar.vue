<script setup>
import { library } from "@fortawesome/fontawesome-svg-core";
import { faTimes, faTrash } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faTimes, faTrash);

const props = defineProps({
    docente: Object,
});
</script>

<template>
    <div
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl font-bold">Desactivar Docente</h2>
            <p>
                ¿Estás seguro de que deseas marcar como inactivo al Docente
                <strong>{{ docente.name }}</strong
                >?
            </p>
            <p class="mt-2 text-sm text-gray-500">
                Esta acción no eliminará al docente, solo lo desactivará y no
                estará disponible para ser utilizado.
            </p>
            <div class="flex justify-end mt-6 space-x-4">
                <button
                    @click="$emit('confirmar')"
                    class="flex items-center px-2 py-2 text-white transition-all duration-300 bg-red-500 rounded-lg shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="trash" class="mr-2 text-lg" />
                    Desactivar
                </button>
                <button
                    @click="$emit('cancelar')"
                    class="flex items-center px-2 py-2 text-white transition-all duration-300 bg-gray-500 rounded-lg shadow hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="times" class="mr-2 text-lg" />
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

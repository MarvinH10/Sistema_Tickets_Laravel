<script setup>
import { library } from "@fortawesome/fontawesome-svg-core";
import { faTimes } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faTimes);

const props = defineProps({
    sede: Object,
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
            <h2 class="mb-4 text-xl font-bold">Detalles de la Sede</h2>
            <p><strong>Nombre:</strong> {{ sede.sed_nombre }}</p>
            <p><strong>Dirección:</strong> {{ sede.sed_direccion }}</p>
            <p><strong>Ciudad:</strong> {{ sede.sed_ciudad }}</p>
            <p><strong>Teléfono:</strong> {{ sede.sed_telefono }}</p>
            <button
                @click="cerrarDetallesModal"
                class="flex items-center px-2 py-2 mt-4 text-white transition-all duration-300 bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
            >
                <font-awesome-icon icon="times" class="mr-2 text-lg" />
                Cerrar
            </button>
        </div>
    </div>
</template>

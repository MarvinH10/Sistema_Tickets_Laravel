<script setup>

</script>

<template>
    <div v-if="mostrarModalDetalles" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <h2 class="text-xl font-bold mb-4">Detalles de la Sede</h2>
            <p><strong>Nombre:</strong> {{ sedeSeleccionada.nombre }}</p>
            <p><strong>Dirección:</strong> {{ sedeSeleccionada.direccion }}</p>
            <p><strong>Ciudad:</strong> {{ sedeSeleccionada.ciudad }}</p>
            <p><strong>Teléfono:</strong> {{ sedeSeleccionada.telefono }}</p>
            <p><strong>Correo:</strong> {{ sedeSeleccionada.correo }}</p>
            <p><strong>Código Postal:</strong> {{ sedeSeleccionada.codigoPostal }}</p>
            <button @click="cerrarDetallesModal"
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Cerrar
            </button>
        </div>
    </div>
</template>
<script setup>

</script>

<template>
    <div v-if="mostrarModalCrearSede" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <h2 class="text-xl font-bold mb-4">Crear Nueva Sede</h2>
            <label class="block mb-2">Nombre:</label>
            <input type="text" v-model="nuevaSede.nombre" class="border p-2 w-full rounded mb-4" />
            <label class="block mb-2">Dirección:</label>
            <input type="text" v-model="nuevaSede.direccion" class="border p-2 w-full rounded mb-4" />
            <label class="block mb-2">Ciudad:</label>
            <input type="text" v-model="nuevaSede.ciudad" class="border p-2 w-full rounded mb-4" />
            <label class="block mb-2">Código Postal:</label>
            <input type="text" v-model="nuevaSede.codigoPostal" class="border p-2 w-full rounded mb-4" />
            <label class="block mb-2">Teléfono:</label>
            <input type="text" v-model="nuevaSede.telefono" class="border p-2 w-full rounded mb-4" />
            <label class="block mb-2">Correo Electrónico:</label>
            <input type="email" v-model="nuevaSede.correo" class="border p-2 w-full rounded mb-4" />
            <button @click="crearSede" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Crear
            </button>
            <button @click="cerrarCrearSedeModal" class="ml-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Cancelar
            </button>
        </div>
    </div>
</template>
<script setup>

</script>

<template>
    <div v-if="isCardView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="sede in filteredSedes" :key="sede.id"
        class="relative bg-white shadow-lg rounded-lg p-4 transition-transform transform hover:scale-105">
        <h2 class="text-xl font-semibold">{{ sede.sed_nombre }}</h2>
        <p class="text-gray-600">{{ sede.sed_direccion }}</p>
        <p class="text-gray-600">Ciudad: {{ sede.sed_ciudad }}</p>
        <p class="text-gray-600">Teléfono: {{ sede.sed_telefono }}</p>
        <div class="mt-4 flex justify-between items-center space-x-2">
          <button @click="showDetallesModal(sede)" class="text-blue-500 hover:text-blue-700 transition duration-300">
            <i class="fas fa-eye"></i> <!-- Icono de ojo para ver detalles -->
          </button>
          <button @click="showEditarModal(sede)" class="text-green-500 hover:text-green-700 transition duration-300">
            <i class="fas fa-edit"></i> <!-- Icono de editar -->
          </button>
        </div>
      </div>
    </div>
</template>
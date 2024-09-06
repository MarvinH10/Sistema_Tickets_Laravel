<template>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Lista de Tickets</h1>

    <!-- Botón para alternar entre Cards y Lista -->
    <div class="mb-4 flex justify-end">
      <button
        @click="toggleView"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-300"
      >
        <i :class="isCardView ? 'fas fa-list' : 'fas fa-table'"></i>
      </button>
    </div>

    <!-- Mostrar los tickets en vista de cards o en lista -->
    <div v-if="isCardView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Vista de Cards -->
      <div
        v-for="ticket in tickets"
        :key="ticket.id"
        class="relative bg-white shadow-lg rounded-lg p-4 transition-transform transform hover:scale-105"
      >
        <!-- Estado en la parte superior derecha -->
        <div class="absolute top-2 right-2 bg-gray-200 text-gray-800 px-2 py-1 rounded text-xs">
          {{ ticket.estado }}
        </div>

        <h2 class="text-xl font-semibold">{{ ticket.tic_titulo }}</h2>
        <p class="text-gray-600">{{ ticket.tic_descripcion }}</p>

        <div class="mt-2">
          <span class="text-sm text-gray-500">Prioridad: {{ ticket.prioridad }}</span>
        </div>

        <div class="mt-4">
          <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Ver detalles</button>
        </div>
      </div>
    </div>

    <div v-else>
      <!-- Vista de Lista -->
      <table class="min-w-full bg-white border">
        <thead>
          <tr>
            <th class="px-4 py-2 border">Título</th>
            <th class="px-4 py-2 border">Descripción</th>
            <th class="px-4 py-2 border">Prioridad</th>
            <th class="px-4 py-2 border">Estado</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ticket in tickets" :key="ticket.id" class="border-t">
            <td class="px-4 py-2 border">{{ ticket.tic_titulo }}</td>
            <td class="px-4 py-2 border">{{ ticket.tic_descripcion }}</td>
            <td class="px-4 py-2 border">{{ ticket.prioridad }}</td>
            <td class="px-4 py-2 border">{{ ticket.estado }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // Variable para controlar si se muestra en cards o en lista
      isCardView: true,

      // Datos simulados de tickets
      tickets: [
        {
          id: 1,
          tic_titulo: 'Problema con el servidor',
          tic_descripcion: 'El servidor principal no responde.',
          prioridad: 'Alta',
          estado: 'Abierto',
        },
        {
          id: 2,
          tic_titulo: 'Error en la base de datos',
          tic_descripcion: 'Los datos no se están guardando correctamente.',
          prioridad: 'Media',
          estado: 'En proceso',
        },
        {
          id: 3,
          tic_titulo: 'Solicitud de acceso',
          tic_descripcion: 'Necesito acceso a una aplicación.',
          prioridad: 'Baja',
          estado: 'Cerrado',
        },
      ],
    };
  },
  methods: {
    // Método para alternar entre vista de cards y lista
    toggleView() {
      this.isCardView = !this.isCardView;
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 1200px;
}
</style>

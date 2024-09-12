<script>
import { Pie, Bar } from 'vue-chartjs';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  data() {
    return {
      tickets: [
        { id: 1, titulo: "Problema con servidor", prioridad: "Alta", estado: "Abierto", fechaCreacion: "2024-09-01" },
        { id: 2, titulo: "Error en base de datos", prioridad: "Media", estado: "Cerrado", fechaCreacion: "2024-09-02" },
        { id: 3, titulo: "Solicitud de acceso", prioridad: "Baja", estado: "Abierto", fechaCreacion: "2024-09-03" },
        { id: 4, titulo: "Actualización de sistema", prioridad: "Alta", estado: "Cerrado", fechaCreacion: "2024-09-04" },
      ],
    };
  },
  computed: {

    estadoChartData() {
      const ticketsAbiertos = this.tickets.filter(ticket => ticket.estado === 'Abierto').length;
      const ticketsCerrados = this.tickets.filter(ticket => ticket.estado === 'Cerrado').length;

      return {
        labels: ['Abiertos', 'Cerrados'],
        datasets: [
          {
            label: 'Tickets por Estado',
            data: [ticketsAbiertos, ticketsCerrados],
            backgroundColor: ['#fffff', '#EF4444'], // Verde para abiertos, rojo para cerrados
          }
        ]
      };
    },

    prioridadChartData() {
      const prioridadAlta = this.tickets.filter(ticket => ticket.prioridad === 'Alta').length;
      const prioridadMedia = this.tickets.filter(ticket => ticket.prioridad === 'Media').length;
      const prioridadBaja = this.tickets.filter(ticket => ticket.prioridad === 'Baja').length;

      return {
        labels: ['Alta', 'Media', 'Baja'],
        datasets: [
          {
            label: 'Tickets por Prioridad',
            data: [prioridadAlta, prioridadMedia, prioridadBaja],
            backgroundColor: ['#F87171', '#FDBA74', '#34D399'],
            borderColor: ['#E11D48', '#F97316', '#10B981'],
            borderWidth: 1
          }
        ]
      };
    }
  }
};
</script>

<template>
  <div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Dashboard del Sistema de Tickets</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <div class="bg-white shadow-lg p-6 rounded-lg chart-container">
        <h2 class="text-2xl font-bold mb-4">Tickets por Estado</h2>
      </div>
      <div class="bg-white shadow-lg p-6 rounded-lg chart-container">
        <h2 class="text-2xl font-bold mb-4">Tickets por Prioridad</h2>
      </div>
    </div>
    <h2 class="text-2xl font-bold mb-4">Lista de Tickets Recientes</h2>
    <div class="bg-white shadow-lg p-4 rounded-lg">
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2 text-left">ID</th>
            <th class="py-2 text-left">Título</th>
            <th class="py-2 text-left">Prioridad</th>
            <th class="py-2 text-left">Estado</th>
            <th class="py-2 text-left">Fecha de Creación</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ticket in tickets" :key="ticket.id" class="border-t">
            <td class="py-2">{{ ticket.id }}</td>
            <td class="py-2">{{ ticket.titulo }}</td>
            <td class="py-2">{{ ticket.prioridad }}</td>
            <td :class="{ 'text-green-500': ticket.estado === 'Abierto', 'text-red-500': ticket.estado === 'Cerrado' }"
              class="py-2">{{ ticket.estado }}</td>
            <td class="py-2">{{ ticket.fechaCreacion }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
.dashboard-container {
  max-width: 1200px;
  margin: 0 auto;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f4f4f4;
}

tbody tr:hover {
  background-color: #f9f9f9;
}

.chart-container {
  position: relative;
  height: 400px;
  width: 100%;
}
</style>
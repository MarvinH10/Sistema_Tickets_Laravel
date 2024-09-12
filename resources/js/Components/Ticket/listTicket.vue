<script>
export default {
  data() {
    return {
      isCardView: true,
      mostrarModalCrearTicket: false,
      mostrarModalDetalles: false,
      mostrarModalAsignarSoporte: false,
      ticketSeleccionado: {},
      nuevoTicket: {
        titulo: '',
        descripcion: '',
        prioridad: 'Media',
        usuario: '',
        categoria: ''
      },
      soporteAsignado: '',
      searchQuery: '', // Barra de búsqueda
      tickets: [
        {
          id: 1,
          tic_titulo: 'Problema con el servidor',
          tic_descripcion: 'El servidor principal no responde correctamente.',
          prioridad: 'Alta',
          estado: 'Abierto',
          usuario: 'Juan Perez',
          categoria: 'Infraestructura',
        },
        {
          id: 2,
          tic_titulo: 'Error en la base de datos',
          tic_descripcion: 'Los datos no se están guardando correctamente.',
          prioridad: 'Media',
          estado: 'En proceso',
          usuario: 'Maria Lopez',
          categoria: 'Desarrollo',
        },
        {
          id: 3,
          tic_titulo: 'Solicitud de acceso',
          tic_descripcion: 'Necesito acceso a una aplicación correctamente.',
          prioridad: 'Baja',
          estado: 'Cerrado',
          usuario: 'Carlos Garcia',
          categoria: 'Soporte Técnico',
        },
      ],
    };
  },
  computed: {
    filteredTickets() {
      return this.tickets.filter(ticket => {
        const search = this.searchQuery.toLowerCase();
        return (
          ticket.tic_titulo.toLowerCase().includes(search) ||
          ticket.estado.toLowerCase().includes(search) ||
          ticket.prioridad.toLowerCase().includes(search) ||
          ticket.usuario.toLowerCase().includes(search) ||
          ticket.categoria.toLowerCase().includes(search)
        );
      });
    }
  },
  methods: {
    toggleView() {
      this.isCardView = !this.isCardView;
    },

    showCrearTicketModal() {
      this.mostrarModalCrearTicket = true;
    },

    cerrarCrearTicketModal() {
      this.mostrarModalCrearTicket = false;
    },

    crearTicket() {
      const nuevo = {
        id: this.tickets.length + 1,
        tic_titulo: this.nuevoTicket.titulo,
        tic_descripcion: this.nuevoTicket.descripcion,
        prioridad: this.nuevoTicket.prioridad,
        estado: 'Abierto',
        usuario: this.nuevoTicket.usuario,
        categoria: this.nuevoTicket.categoria
      };
      this.tickets.push(nuevo);
      this.cerrarCrearTicketModal();
    },

    showDetallesModal(ticket) {
      this.ticketSeleccionado = ticket;
      this.mostrarModalDetalles = true;
    },

    cerrarDetallesModal() {
      this.mostrarModalDetalles = false;
    },

    showAsignarSoporteModal(ticket) {
      this.ticketSeleccionado = ticket;
      this.mostrarModalAsignarSoporte = true;
    },
    cerrarAsignarSoporteModal() {
      this.mostrarModalAsignarSoporte = false;
    },
    asignarSoporte() {
      alert(`El ticket "${this.ticketSeleccionado.tic_titulo}" ha sido asignado a ${this.soporteAsignado}`);
      this.cerrarAsignarSoporteModal();
    },
  },
};
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Lista de Tickets</h1>

    <!-- Barra de búsqueda -->
    <div class="mb-4">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Buscar por título, estado, prioridad, usuario o categoría..."
        class="border p-2 w-full rounded"
      />
    </div>

    <div class="mb-4 flex justify-end">
      <button @click="showCrearTicketModal"
        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-300 mr-2">
        Crear Ticket
      </button>
      <button @click="toggleView"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-300">
        <i :class="isCardView ? 'fas fa-list' : 'fas fa-table'"></i>
      </button>
    </div>

    <!-- Vista en tarjetas -->
    <div v-if="isCardView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="ticket in filteredTickets" :key="ticket.id"
        class="relative bg-white shadow-lg rounded-lg p-4 transition-transform transform hover:scale-105">
        <div class="absolute top-2 right-2 px-2 py-1 rounded text-xs" :class="{
          'bg-green-700 text-white': ticket.estado === 'Abierto',
          'bg-yellow-700 text-white': ticket.estado === 'En proceso',
          'bg-red-700 text-white': ticket.estado === 'Cerrado'
        }">
          {{ ticket.estado }}
        </div>
        <h2 class="text-xl font-semibold">{{ ticket.tic_titulo }}</h2>
        <p class="text-gray-600">{{ ticket.tic_descripcion }}</p>
        <div class="mt-2">
          <span class="text-sm text-gray-500">Prioridad: {{ ticket.prioridad }}</span>
        </div>
        <div class="mt-1">
          <span class="text-sm text-gray-500">Usuario: {{ ticket.usuario }}</span>
        </div>
        <div class="mt-1">
          <span class="text-sm text-gray-500">Categoría: {{ ticket.categoria }}</span>
        </div>
        <div class="mt-4 flex justify-between items-center space-x-2">
          <button @click="showDetallesModal(ticket)" class="text-blue-500 hover:text-blue-700 transition duration-300">
            <i class="fas fa-eye"></i>
          </button>
          <button @click="showAsignarSoporteModal(ticket)"
            class="text-purple-500 hover:text-purple-700 transition duration-300">
            <i class="fas fa-user-plus"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Vista en tabla -->
    <div v-else>
      <table class="min-w-full bg-white border">
        <thead>
          <tr>
            <th class="px-4 py-2 border">Título</th>
            <th class="px-4 py-2 border">Descripción</th>
            <th class="px-4 py-2 border">Prioridad</th>
            <th class="px-4 py-2 border">Estado</th>
            <th class="px-4 py-2 border">Usuario</th>
            <th class="px-4 py-2 border">Categoría</th>
            <th class="px-4 py-2 border">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ticket in filteredTickets" :key="ticket.id" class="border-t">
            <td class="px-4 py-2 border">{{ ticket.tic_titulo }}</td>
            <td class="px-4 py-2 border">{{ ticket.tic_descripcion }}</td>
            <td class="px-4 py-2 border">{{ ticket.prioridad }}</td>
            <td class="px-4 py-2 border">{{ ticket.estado }}</td>
            <td class="px-4 py-2 border">{{ ticket.usuario }}</td>
            <td class="px-4 py-2 border">{{ ticket.categoria }}</td>
            <td class="px-4 py-2 border flex justify-between space-x-2">
              <button @click="showDetallesModal(ticket)"
                class="text-blue-500 hover:text-blue-700 transition duration-300">
                <i class="fas fa-eye"></i>
              </button>
              <button @click="showAsignarSoporteModal(ticket)"
                class="text-purple-500 hover:text-purple-700 transition duration-300">
                <i class="fas fa-user-plus"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal Crear Ticket -->
    <div v-if="mostrarModalCrearTicket" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4">Crear Nuevo Ticket</h2>
        <label class="block mb-2">Título:</label>
        <input type="text" v-model="nuevoTicket.titulo" class="border p-2 w-full rounded mb-4" />
        <label class="block mb-2">Descripción:</label>
        <textarea v-model="nuevoTicket.descripcion" class="border p-2 w-full rounded mb-4"></textarea>
        <label class="block mb-2">Prioridad:</label>
        <select v-model="nuevoTicket.prioridad" class="border p-2 w-full rounded mb-4">
          <option value="Alta">Alta</option>
          <option value="Media">Media</option>
          <option value="Baja">Baja</option>
        </select>
        <label class="block mb-2">Usuario:</label>
        <input type="text" v-model="nuevoTicket.usuario" class="border p-2 w-full rounded mb-4" />
        <label class="block mb-2">Categoría:</label>
        <input type="text" v-model="nuevoTicket.categoria" class="border p-2 w-full rounded mb-4" />
        <button @click="crearTicket" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
          Crear
        </button>
        <button @click="cerrarCrearTicketModal" class="ml-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
          Cancelar
        </button>
      </div>
    </div>
    
    <!-- Modal Detalles Ticket -->
    <div v-if="mostrarModalDetalles" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4">Detalles del Ticket</h2>
        <p><strong>Título:</strong> {{ ticketSeleccionado.tic_titulo }}</p>
        <p><strong>Descripción:</strong> {{ ticketSeleccionado.tic_descripcion }}</p>
        <p><strong>Prioridad:</strong> {{ ticketSeleccionado.prioridad }}</p>
        <p><strong>Estado:</strong> {{ ticketSeleccionado.estado }}</p>
        <p><strong>Usuario:</strong> {{ ticketSeleccionado.usuario }}</p>
        <p><strong>Categoría:</strong> {{ ticketSeleccionado.categoria }}</p>
        <button @click="cerrarDetallesModal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Cerrar
        </button>
      </div>
    </div>

    <!-- Modal Asignar Soporte -->
    <div v-if="mostrarModalAsignarSoporte"
      class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4">Asignar a Soporte</h2>
        <p><strong>Título:</strong> {{ ticketSeleccionado.tic_titulo }}</p>
        <label class="block mb-2">Asignar a:</label>
        <input type="text" v-model="soporteAsignado" class="border p-2 w-full rounded mb-4" />
        <button @click="asignarSoporte" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
          Asignar
        </button>
        <button @click="cerrarAsignarSoporteModal"
          class="ml-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
          Cancelar
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.space-x-2 {
  gap: 0.5rem;
}

.flex {
  display: flex;
}

.items-center {
  align-items: center;
}

.justify-between {
  justify-content: space-between;
}

.w-full {
  width: 100%;
}
</style>
  
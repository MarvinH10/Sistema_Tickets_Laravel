<script>
export default {
  data() {
    return {
      mostrarModalCrearUsuario: false,
      mostrarModalDetalles: false,
      mostrarModalEditar: false,
      usuarioSeleccionado: {},
      nuevoUsuario: {
        nombre: '',
        apellido: '',
        correo: '',
        telefono: '',
        rol: 'Usuario',
      },
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 5,
      usuarios: [
        {
          id: 1,
          nombre: 'Juan',
          apellido: 'Perez',
          correo: 'juan.perez@example.com',
          telefono: '123-456-7890',
          rol: 'Administrador',
        },
        {
          id: 2,
          nombre: 'Maria',
          apellido: 'Lopez',
          correo: 'maria.lopez@example.com',
          telefono: '987-654-3210',
          rol: 'Usuario',
        },
        {
          id: 3,
          nombre: 'Carlos',
          apellido: 'Garcia',
          correo: 'carlos.garcia@example.com',
          telefono: '456-789-1230',
          rol: 'Soporte',
        },
        // Añadir más usuarios...
      ],
    };
  },
  computed: {
    filteredUsuarios() {
      const search = this.searchQuery.toLowerCase();
      return this.usuarios.filter(usuario => {
        return (
          usuario.nombre.toLowerCase().includes(search) ||
          usuario.apellido.toLowerCase().includes(search) ||
          usuario.correo.toLowerCase().includes(search) ||
          usuario.telefono.includes(search) ||
          usuario.rol.toLowerCase().includes(search)
        );
      });
    },
    paginatedUsuarios() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredUsuarios.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredUsuarios.length / this.itemsPerPage);
    },
  },
  methods: {
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },

    showCrearUsuarioModal() {
      this.mostrarModalCrearUsuario = true;
    },

    cerrarCrearUsuarioModal() {
      this.mostrarModalCrearUsuario = false;
    },

    crearUsuario() {
      const nuevo = {
        id: this.usuarios.length + 1,
        ...this.nuevoUsuario
      };
      this.usuarios.push(nuevo);
      this.cerrarCrearUsuarioModal();
    },

    showDetallesModal(usuario) {
      this.usuarioSeleccionado = usuario;
      this.mostrarModalDetalles = true;
    },

    cerrarDetallesModal() {
      this.mostrarModalDetalles = false;
    },

    showEditarModal(usuario) {
      this.usuarioSeleccionado = usuario;
      this.mostrarModalEditar = true;
      this.nuevoUsuario = { ...usuario };
    },

    cerrarEditarModal() {
      this.mostrarModalEditar = false;
    },

    editarUsuario() {
      const index = this.usuarios.findIndex(usuario => usuario.id === this.nuevoUsuario.id);
      if (index !== -1) {
        this.usuarios[index] = { ...this.nuevoUsuario };
      }
      this.cerrarEditarModal();
    },
  },
};
</script>

<template>
  <div class="container p-6 main-container">
    <h1 class="text-2xl font-bold mb-4">Lista de Usuarios</h1>

    <!-- Barra de búsqueda -->
    <div class="mb-2 flex justify-end pb-6">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Buscar por nombre, apellido, correo, teléfono o rol..."
        class="border p-1 w-full rounded mr-4"
      />
      <button @click="showCrearUsuarioModal"
        class="bg-green-500 text-white rounded hover:bg-green-600 transition duration-300">
        Crear Usuario
      </button>
    </div>

    <!-- Tabla interactiva con paginación -->
    <table class="min-w-full bg-white border">
      <thead>
        <tr>
          <th class="px-4 py-2 border">Nombre</th>
          <th class="px-4 py-2 border">Apellido</th>
          <th class="px-4 py-2 border">Correo</th>
          <th class="px-4 py-2 border">Teléfono</th>
          <th class="px-4 py-2 border">Rol</th>
          <th class="px-4 py-2 border">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="usuario in paginatedUsuarios" :key="usuario.id" class="border-t">
          <td class="px-4 py-2 border">{{ usuario.nombre }}</td>
          <td class="px-4 py-2 border">{{ usuario.apellido }}</td>
          <td class="px-4 py-2 border">{{ usuario.correo }}</td>
          <td class="px-4 py-2 border">{{ usuario.telefono }}</td>
          <td class="px-4 py-2 border">{{ usuario.rol }}</td>
          <td class="px-4 py-2 border flex justify-between space-x-2">
            <button @click="showDetallesModal(usuario)" class="text-blue-500 hover:text-blue-700 transition duration-300">
              <i class="fas fa-eye"></i>
            </button>
            <button @click="showEditarModal(usuario)" class="text-green-500 hover:text-green-700 transition duration-300">
              <i class="fas fa-edit"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Paginación -->
    <div class="mt-4 flex justify-end space-x-2">
      <button 
        @click="goToPage(currentPage - 1)" 
        :disabled="currentPage === 1"
        class="bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400 disabled:bg-gray-200"
      >
        Anterior
      </button>
      <span class="text-gray-700">Página {{ currentPage }} de {{ totalPages }}</span>
      <button 
        @click="goToPage(currentPage + 1)" 
        :disabled="currentPage === totalPages"
        class="bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400 disabled:bg-gray-200"
      >
        Siguiente
      </button>
    </div>

    <!-- Modal Crear Usuario -->
    <div v-if="mostrarModalCrearUsuario" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4">Crear Nuevo Usuario</h2>
        <label class="block mb-2">Nombre:</label>
        <input type="text" v-model="nuevoUsuario.nombre" class="border p-2 w-full rounded mb-4" />
        <label class="block mb-2">Apellido:</label>
        <input type="text" v-model="nuevoUsuario.apellido" class="border p-2 w-full rounded mb-4" />
        <label class="block mb-2">Correo Electrónico:</label>
        <input type="email" v-model="nuevoUsuario.correo" class="border p-2 w-full rounded mb-4" />
        <label class="block mb-2">Teléfono:</label>
        <input type="text" v-model="nuevoUsuario.telefono" class="border p-2 w-full rounded mb-4" />
        <label class="block mb-2">Rol:</label>
        <select v-model="nuevoUsuario.rol" class="border p-2 w-full rounded mb-4">
          <option value="Administrador">Administrador</option>
          <option value="Usuario">Usuario</option>
          <option value="Soporte">Soporte</option>
        </select>
        <button @click="crearUsuario" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
          Crear
        </button>
        <button @click="cerrarCrearUsuarioModal" class="ml-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
          Cancelar
        </button>
      </div>
    </div>

    <!-- Modal Detalles Usuario -->
    <div v-if="mostrarModalDetalles" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4">Detalles del Usuario</h2>
        <p><strong>Nombre:</strong> {{ usuarioSeleccionado.nombre }}</p>
        <p><strong>Apellido:</strong> {{ usuarioSeleccionado.apellido }}</p>
        <p><strong>Correo:</strong> {{ usuarioSeleccionado.correo }}</p>
        <p><strong>Teléfono:</strong> {{ usuarioSeleccionado.telefono }}</p>
        <p><strong>Rol:</strong> {{ usuarioSeleccionado.rol }}</p>
        <button @click="cerrarDetallesModal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Cerrar
        </button>
      </div>
    </div>

    <!-- Modal Editar Usuario -->
    <div v-if="mostrarModalEditar" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4">Editar Usuario</h2>
        <label class="block mb-2">Nombre:</label>
        <input type="text" v-model="nuevoUsuario.nombre" class="border p-2 w-full rounded mb-4" />
        <label class="block mb-2">Apellido:</label>
        <input type="text" v-model="nuevoUsuario.apellido" class="border p-2 w-full rounded mb-4" />
        <label class="block mb-2">Correo Electrónico:</label>
        <input type="email" v-model="nuevoUsuario.correo" class="border p-2 w-full rounded mb-4" />
        <label class="block mb-2">Teléfono:</label>
        <input type="text" v-model="nuevoUsuario.telefono" class="border p-2 w-full rounded mb-4" />
        <label class="block mb-2">Rol:</label>
        <select v-model="nuevoUsuario.rol" class="border p-2 w-full rounded mb-4">
          <option value="Administrador">Administrador</option>
          <option value="Usuario">Usuario</option>
          <option value="Soporte">Soporte</option>
        </select>
        <button @click="editarUsuario" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
          Guardar Cambios
        </button>
        <button @click="cerrarEditarModal" class="ml-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
          Cancelar
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.main-container {
  max-width: 1600px;
  padding: 20px;
}

.container {
  max-width: 1200px;
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

.mt-4 {
  margin-top: 1rem;
}
</style>

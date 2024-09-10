<script setup>
import { ref, onMounted } from "vue";

const sedes = ref([]);

const validatePhoneNumber = (telefono) => {
  const phone = telefono.toString();
  return phone.startsWith("+51") ? phone : `+51${phone}`;
};

const fetchSedes = async () => {
  try {
    const response = await fetch("/api/sedes");
    const data = await response.json();
    sedes.value = data.map((sede) => ({
      id: sede.id,
      nombre: sede.sed_nombre,
      direccion: sede.sed_direccion,
      ciudad: sede.sed_ciudad,
      telefono: validatePhoneNumber(sede.sed_telefono),
      correo: sede.sed_correo
    }));
  } catch (error) {
    console.error("Error al cargar las sedes:", error);
  }
};

onMounted(() => {
  fetchSedes();
});
</script>

<template>
  <div class="container p-6 main-container">
    <h1 class="text-2xl font-bold mb-6">Lista de Sedes</h1>

    <!-- Barra de búsqueda -->
    <div class="mb-4">
      <input v-model="searchQuery" type="text" placeholder="Buscar por nombre, dirección, ciudad, teléfono o correo..."
        class="border p-2 w-full rounded" />
    </div>

    <div class="mb-4 flex justify-end">
      <button @click="showCrearSedeModal"
        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-300 mr-2">
        Crear Sede
      </button>
      <button @click="toggleView"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-300">
        <i :class="isCardView ? 'fas fa-list' : 'fas fa-table'"></i>
      </button>
    </div>

    <!-- Vista en tarjetas -->
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

    <!-- Vista en tabla -->
    <div v-else>
      <table class="min-w-full bg-white border">
        <thead>
          <tr>
            <th class="px-4 py-2 border">Nombre</th>
            <th class="px-4 py-2 border">Dirección</th>
            <th class="px-4 py-2 border">Ciudad</th>
            <th class="px-4 py-2 border">Teléfono</th>
            <th class="px-4 py-2 border">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="sede in sedes" :key="sede.id" class="border-t">
            <td class="px-4 py-2 border">{{ sede.nombre }}</td>
            <td class="px-4 py-2 border">{{ sede.direccion }}</td>
            <td class="px-4 py-2 border">{{ sede.ciudad }}</td>
            <td class="px-4 py-2 border">{{ sede.telefono }}</td>
            <td class="px-4 py-2 border flex justify-between space-x-2">
              <button @click="showDetallesModal(sede)"
                class="text-blue-500 hover:text-blue-700 transition duration-300">
                <i class="fas fa-eye"></i>
              </button>
              <button @click="showEditarModal(sede)"
                class="text-green-500 hover:text-green-700 transition duration-300">
                <i class="fas fa-edit"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal Crear Sede -->
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

    <!-- Modal Detalles Sede -->
    <div v-if="mostrarModalDetalles" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4">Detalles de la Sede</h2>
        <p><strong>Nombre:</strong> {{ sedeSeleccionada.nombre }}</p>
        <p><strong>Dirección:</strong> {{ sedeSeleccionada.direccion }}</p>
        <p><strong>Ciudad:</strong> {{ sedeSeleccionada.ciudad }}</p>
        <p><strong>Teléfono:</strong> {{ sedeSeleccionada.telefono }}</p>
        <p><strong>Correo:</strong> {{ sedeSeleccionada.correo }}</p>
        <p><strong>Código Postal:</strong> {{ sedeSeleccionada.codigoPostal }}</p>
        <button @click="cerrarDetallesModal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Cerrar
        </button>
      </div>
    </div>

    <!-- Modal Editar Sede -->
    <div v-if="mostrarModalEditar" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-xl font-bold mb-4">Editar Sede</h2>
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
        <button @click="editarSede" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
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

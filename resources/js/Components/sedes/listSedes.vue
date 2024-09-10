<script setup>
import { ref, onMounted } from "vue";

const sedes = ref([]);

const validatePhoneNumber = (telefono) => {
  const phone = telefono.toString();
  return phone.startsWith("+51") ? phone : `+51 ${phone}`;
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
    <!-- <div class="mb-4">
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
        <i :class="isListView ? 'fas fa-list' : 'fas fa-table'"></i>
      </button>
    </div> -->

    <div>
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

    <!-- Modal Crear Sede Aquí -->

    <!-- Modal Detalles Sede Aquí -->

    <!-- Modal Editar Sede Aquí -->
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

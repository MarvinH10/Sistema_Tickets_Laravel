<script>
export default {
    data() {
        return {
            mostrarModal: false,
            mostrarModalConfirmacion: false,
            aulaSeleccionada: null,
            nuevaAula: {
                nombre: '',
                pabellon: ''
            },
            pabellones: ['Pabellón A', 'Pabellón B', 'Pabellón C'],
            aulas: [
                { id: 1, nombre: 'Aula 101', pabellon: 'Pabellón A' },
                { id: 2, nombre: 'Aula 102', pabellon: 'Pabellón A' },
                { id: 3, nombre: 'Aula 201', pabellon: 'Pabellón B' },
            ],
        };
    },
    methods: {

        mostrarModalCrearAula() {
            this.mostrarModal = true;
            this.nuevaAula = { nombre: '', pabellon: '' };
        },

        cerrarModal() {
            this.mostrarModal = false;
        },

        crearAula() {
            const nueva = {
                id: this.aulas.length + 1,
                nombre: this.nuevaAula.nombre,
                pabellon: this.nuevaAula.pabellon
            };
            this.aulas.push(nueva);
            this.cerrarModal();
        },

        confirmarEliminacion(aula) {
            this.aulaSeleccionada = aula;
            this.mostrarModalConfirmacion = true;
        },
        cerrarModalConfirmacion() {
            this.mostrarModalConfirmacion = false;
        },

        eliminarAulaConfirmada() {
            this.aulas = this.aulas.filter(aula => aula.id !== this.aulaSeleccionada.id);
            this.cerrarModalConfirmacion();
        },

        mostrarModalEditarAula(aula) {
            this.nuevaAula = { ...aula };
            this.mostrarModal = true;
        }
    }
};
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Gestión de Aulas</h1>
        <div class="mb-4 flex justify-end">
            <button @click="mostrarModalCrearAula"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-300">
                Crear Aula
            </button>
        </div>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Aula</th>
                    <th class="px-4 py-2 border">Pabellón</th>
                    <th class="px-4 py-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="aula in aulas" :key="aula.id" class="border-t">
                    <td class="px-4 py-2 border">{{ aula.nombre }}</td>
                    <td class="px-4 py-2 border">{{ aula.pabellon }}</td>
                    <td class="px-4 py-2 border">
                        <div class="flex justify-center items-center space-x-2">
                            <!-- Botón para editar -->
                            <button @click="mostrarModalEditarAula(aula)"
                                class="text-blue-500 hover:text-blue-700 transition duration-300">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- Botón para eliminar con confirmación -->
                            <button @click="confirmarEliminacion(aula)"
                                class="text-red-500 hover:text-red-700 transition duration-300">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="mostrarModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-xl font-bold mb-4">Crear Nueva Aula</h2>
                <label class="block mb-2">Nombre del Aula:</label>
                <input type="text" v-model="nuevaAula.nombre" class="border p-2 w-full rounded mb-4" />
                <label class="block mb-2">Pabellón:</label>
                <select v-model="nuevaAula.pabellon" class="border p-2 w-full rounded mb-4">
                    <option v-for="pabellon in pabellones" :key="pabellon" :value="pabellon">{{ pabellon }}</option>
                </select>
                <button @click="crearAula" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Crear
                </button>
                <button @click="cerrarModal" class="ml-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Cancelar
                </button>
            </div>
        </div>
        <div v-if="mostrarModalConfirmacion"
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                <h2 class="text-xl font-bold mb-4">¿Estás seguro?</h2>
                <p>¿Estás seguro de que deseas eliminar el aula <strong>{{ aulaSeleccionada.nombre }}</strong>?</p>
                <div class="mt-4 flex justify-end space-x-4">
                    <button @click="eliminarAulaConfirmada"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Sí, eliminar
                    </button>
                    <button @click="cerrarModalConfirmacion"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.container {
    max-width: 1200px;
    margin: auto;
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

.justify-center {
    justify-content: center;
}

.w-full {
    width: 100%;
}
</style>
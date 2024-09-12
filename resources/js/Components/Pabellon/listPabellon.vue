<script>
export default {
    data() {
        return {
            mostrarModal: false,
            mostrarModalConfirmacion: false,
            pabellonSeleccionado: null,
            nuevoPabellon: {
                nombre: ''
            },
            pabellones: [
                { id: 1, nombre: 'Pabellón A' },
                { id: 2, nombre: 'Pabellón B' },
                { id: 3, nombre: 'Pabellón C' },
            ],
        };
    },
    methods: {

        mostrarModalCrearPabellon() {
            this.mostrarModal = true;
            this.nuevoPabellon = { nombre: '' };
        },

        cerrarModal() {
            this.mostrarModal = false;
        },

        crearPabellon() {
            const nuevo = {
                id: this.pabellones.length + 1,
                nombre: this.nuevoPabellon.nombre
            };
            this.pabellones.push(nuevo);
            this.cerrarModal();
        },

        confirmarEliminacion(pabellon) {
            this.pabellonSeleccionado = pabellon;
            this.mostrarModalConfirmacion = true;
        },
        cerrarModalConfirmacion() {
            this.mostrarModalConfirmacion = false;
        },

        eliminarPabellonConfirmado() {
            this.pabellones = this.pabellones.filter(pabellon => pabellon.id !== this.pabellonSeleccionado.id);
            this.cerrarModalConfirmacion();
        },

        mostrarModalEditarPabellon(pabellon) {
            this.nuevoPabellon = { ...pabellon };
            this.mostrarModal = true;
        }
    }
};
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Gestión de Pabellones</h1>
        <div class="mb-4 flex justify-end">
            <button @click="mostrarModalCrearPabellon"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-300">
                Crear Pabellón
            </button>
        </div>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Pabellón</th>
                    <th class="px-4 py-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="pabellon in pabellones" :key="pabellon.id" class="border-t">
                    <td class="px-4 py-2 border">{{ pabellon.nombre }}</td>
                    <td class="px-4 py-2 border">
                        <div class="flex justify-center items-center space-x-2">
                            <button @click="mostrarModalEditarPabellon(pabellon)"
                                class="text-blue-500 hover:text-blue-700 transition duration-300">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="confirmarEliminacion(pabellon)"
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
                <h2 class="text-xl font-bold mb-4">Crear Nuevo Pabellón</h2>
                <label class="block mb-2">Nombre del Pabellón:</label>
                <input type="text" v-model="nuevoPabellon.nombre" class="border p-2 w-full rounded mb-4" />
                <button @click="crearPabellon" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
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
                <p>¿Estás seguro de que deseas eliminar el pabellón <strong>{{ pabellonSeleccionado.nombre }}</strong>?
                </p>
                <div class="mt-4 flex justify-end space-x-4">
                    <button @click="eliminarPabellonConfirmado"
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
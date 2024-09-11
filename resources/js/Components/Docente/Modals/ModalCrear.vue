<script setup>
import { ref, onMounted } from "vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faSave, faTimes } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import axios from "axios";

library.add(faSave, faTimes);

const emit = defineEmits(["cerrar", "crear"]);

const nuevoDocente = ref({
    name: "",
    email: "",
    celular: "",
    sed_id: "",
    password: "",
    activo: true,
});

const errores = ref([]);
const sedes = ref([]);

const generarPasswordAleatorio = () => {
    const caracteres =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    let password = "";
    for (let i = 0; i < 8; i++) {
        password += caracteres.charAt(
            Math.floor(Math.random() * caracteres.length)
        );
    }
    return password;
};

const crearDocente = async () => {
    try {
        const response = await axios.post("/docentes", nuevoDocente.value, {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        });
        emit("crear", response.data);

        nuevoDocente.value = {
            name: "",
            email: "",
            celular: "",
            sed_id: "",
            password: generarPasswordAleatorio(),
            activo: true,
        };
        errores.value = [];
        emit("cerrar");
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errores.value = error.response.data.errors;
        } else {
            console.error("Error al crear al docente:", error);
        }
    }
};

const fetchSedes = async () => {
    try {
        const response = await axios.get("/sedes");
        sedes.value = response.data.map((sede) => ({
            value: sede.id,
            text: sede.sed_nombre,
        }));
    } catch (error) {
        console.error("Error al cargar las sedes:", error);
    }
};

const cerrarModal = () => {
    emit("cerrar");
};

onMounted(() => {
    nuevoDocente.value.password = generarPasswordAleatorio();
    fetchSedes();
});
</script>

<template>
    <div
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl font-bold">Crear Nuevo Docente</h2>
            <label class="block mb-2">Nombre:</label>
            <input
                type="text"
                v-model="nuevoDocente.name"
                class="w-full p-2 mb-4 border rounded"
            />
            <label class="block mb-2">Seleccionar Sede:</label>
            <select
                v-model="nuevoDocente.sed_id"
                class="w-full p-2 mb-4 border rounded"
            >
                <option value="" disabled>Selecciona una sede</option>
                <option
                    v-for="sede in sedes"
                    :key="sede.value"
                    :value="sede.value"
                >
                    {{ sede.text }}
                </option>
            </select>
            <label class="block mb-2">Correo:</label>
            <input
                type="text"
                v-model="nuevoDocente.email"
                class="w-full p-2 mb-4 border rounded"
            />
            <label class="block mb-2">Teléfono:</label>
            <input
                type="text"
                v-model="nuevoDocente.celular"
                class="w-full p-2 mb-4 border rounded"
            />
            <label class="block mb-2">Contraseña:</label>
            <input
                type="text"
                v-model="nuevoDocente.password"
                class="w-full p-2 mb-4 border rounded"
            />
            <div class="flex justify-end mt-6 space-x-4">
                <button
                    @click="crearDocente"
                    class="flex items-center px-2 py-2 text-white transition-all duration-300 bg-green-500 rounded-lg shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="save" class="mr-2 text-lg" />
                    Crear
                </button>
                <button
                    @click="cerrarModal"
                    class="flex items-center px-2 py-2 text-white transition-all duration-300 bg-red-500 rounded-lg shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                >
                    <font-awesome-icon icon="times" class="mr-2 text-lg" />
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

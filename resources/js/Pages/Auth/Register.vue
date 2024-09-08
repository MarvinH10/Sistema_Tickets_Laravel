<script setup>
import { ref, onMounted } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";

const sedes = ref([]);

const fetchSedes = async () => {
    try {
        const response = await fetch("/api/sedes");
        const data = await response.json();
        sedes.value = data.map((sede) => ({
            value: sede.id,
            text: sede.sed_nombre,
        }));
    } catch (error) {
        console.error("Error al cargar las sedes:", error);
    }
};

onMounted(() => {
    fetchSedes();
});

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    sed_id: "",
    terms: false,
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>
        <div class="pb-3 font-semibold text-center text-gray-800 uppercase">
            Registrarse
        </div>
        <div class="pb-5 text-sm text-center text-gray-600">
            ¿Ya tienes una cuenta?
            <Link
                :href="route('login')"
                class="font-semibold text-gray-800 hover:text-gray-600 hover:underline"
            >
                Inicia sesión aquí
            </Link>
        </div>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Nombres y Apellidos" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Correo Electrónico" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="block w-full mt-1"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="block w-full mt-1"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirmar Contraseña"
                />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="block w-full mt-1"
                    required
                    autocomplete="new-password"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4">
                <Select
                    id="sed_id"
                    name="sed_id"
                    v-model="form.sed_id"
                    :options="sedes"
                    label="Selecciona una Sede"
                    placeholder="Selecciona una Sede"
                    :required="true"
                    :error="form.errors.sed_id"
                />
            </div>

            <div
                v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
                class="mt-4"
            >
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox
                            id="terms"
                            v-model:checked="form.terms"
                            name="terms"
                            required
                        />

                        <div class="text-xs ms-2">
                            Acepto los
                            <a
                                target="_blank"
                                :href="route('terms.show')"
                                class="text-xs text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >Términos de servicio</a
                            >
                            y
                            <a
                                target="_blank"
                                :href="route('policy.show')"
                                class="text-xs text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >Política de privacidad</a
                            >
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Registrarme
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>

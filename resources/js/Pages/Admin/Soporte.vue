<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import listSoporte from "@/Components/Soporte/listSoporte.vue";
</script>

<template>
    <AppLayout title="Sedes">
        <div class="py-6">
            <div class="mx-auto max-w-9xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <listSoporte />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

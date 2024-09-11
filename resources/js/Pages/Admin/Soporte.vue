<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import listSoporte from "@/Components/Soporte/listSoporte.vue";
</script>

<template>
    <AppLayout title="Sedes">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <listSoporte />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

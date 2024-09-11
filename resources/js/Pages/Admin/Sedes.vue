<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import listSedes from "@/Components/Sedes/listSedes.vue";
</script>

<template>
    <AppLayout title="Sedes">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <listSedes />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

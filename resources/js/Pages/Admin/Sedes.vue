<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import listSedes from '@/Components/sedes/listSedes.vue';
</script>

<template>
    <AppLayout title="Sedes">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <listSedes />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
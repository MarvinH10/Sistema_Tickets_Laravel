<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import listPabellon from '@/Components/Pabellon/listPabellon.vue';
</script>

<template>
    <AppLayout title="Pabellones">
        <div class="py-6">
            <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <listPabellon />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
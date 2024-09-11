<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import listAula from '@/Components/Aula/listAula.vue';
</script>

<template>
    <AppLayout title="Aulas">
        <div class="py-6">
            <listAula />
        </div>
    </AppLayout>
</template>
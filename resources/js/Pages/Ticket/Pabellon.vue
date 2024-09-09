<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import listTicket from '@/Components/Ticket/listTicket.vue';
import Listpabellon from '@/Components/pabellones/Listpabellon.vue';
</script>

<template>
    <AppLayout title="Tickets">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Listpabellon />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import listTicket from '@/Components/Ticket/listTicket.vue';
</script>

<template>
    <AppLayout title="Tickets">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <listTicket />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

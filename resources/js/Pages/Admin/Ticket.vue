<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import listTicket from '@/Components/Ticket/listTicket.vue';
</script>

<template>
    <AppLayout title="Tickets">
        <div class="py-6">
            <listTicket />
        </div>
    </AppLayout>
</template>

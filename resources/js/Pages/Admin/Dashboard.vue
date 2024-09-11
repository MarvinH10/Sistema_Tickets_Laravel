<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import graphicsDashboard from "@/Components/Dashboard/graphicsDashboard.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-6">
            <div class="mx-auto max-w-9xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <graphicsDashboard />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import {Head} from "@inertiajs/vue3";
import Sidebar from "@/Pages/Admin/Sidebar.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

defineProps({
    pageTitle: {
        type: String,
        default: 'Page'
    }
})
</script>

<template>
    <Head :title="pageTitle"/>
    <div class="flex">
        <Sidebar/>
        <div class="flex-1 p-6 max-w-[calc(100%-16em)] ml-64">
            <AdminLayout/>
            <slot/>
        </div>
    </div>
</template>

<style scoped>

</style>

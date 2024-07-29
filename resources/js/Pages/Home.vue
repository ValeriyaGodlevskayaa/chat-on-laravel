<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head} from "@inertiajs/vue3";

export default {
    components: {
        AdminLayout,
        Head
    },
    props: {
        title: String,
    }
}
</script>

<template>
    <Head :title="title"/>

    <AdminLayout>
        <h1>{{title}}</h1>
    </AdminLayout>
</template>

<style scoped>

</style>

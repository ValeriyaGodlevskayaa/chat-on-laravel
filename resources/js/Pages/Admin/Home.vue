<script>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Head} from "@inertiajs/vue3";
import Page from "@/Pages/Admin/Page.vue";

export default {
    components: {
        Page,
        Head,
        AdminLayout
    },
    props: {
        title: String
    }
}
</script>

<template>
    <Page :page-title="title">
        {{title}}
    </Page>

</template>

<style scoped>

</style>

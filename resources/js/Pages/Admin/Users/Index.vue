<script setup>
import Table from "@/Components/Table/Table.vue";
import {ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DialogUser from "@/Pages/Admin/Users/DialogUser.vue";
import EditIcon from "@/Components/EditIcon.vue";
import Page from "@/Pages/Admin/Page.vue";
import MessageIcon from "@/Components/Icons/MessageIcon.vue";
import {route} from "ziggy-js";

const props = defineProps({
    title: String,
    users: Object,
    pagination: Object
});

const hideColumns = [
    'updated_at'
];
const showDialog = ref(false);
const user = ref(null);
const handleEdit = (item) => {
    user.value = item;
    showDialog.value = true;
};
const handleCreate = () => {
    user.value = null;
    showDialog.value = true;
};

</script>

<template>
    <Page :page-title="title">
        <primary-button @click="handleCreate" class="ml-3 mb-3">Create User</primary-button>
        <Table :data="users" :pagination="pagination" :hide-columns="hideColumns">
            <template #editAction="{item}">
                <EditIcon @click="handleEdit(item)"/>
            </template>
            <template #add-action="{item}">
                <MessageIcon :href="route('chat.create', {
                    _query: {
                        user_id: item.id
                    }
                })"></MessageIcon>
            </template>
        </Table>
    </Page>

    <DialogUser v-model:show-dialog="showDialog" v-model:user="user"/>
</template>

<style scoped>

</style>

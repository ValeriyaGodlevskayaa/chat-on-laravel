<script setup>
import { ref, computed } from 'vue';
import Pagination from "@/Components/Table/Pagination.vue";
import EditIcon from "@/Components/EditIcon.vue";
import DeleteIcon from "@/Components/DeleteIcon.vue";
import {router} from "@inertiajs/vue3";
import {route, useRoute} from "ziggy-js";

const props = defineProps({
    data: Object,
    columns: Array,
    hideColumns: Array,
    pagination: Object,
    deleteFunc: {
        type: Function,
        default: null
    }
});

const headers = computed(() => {
    let columns;
    if (!props.columns && props.data.data.length) {
        columns = Object.keys(props.data.data[0]);
    } else {
        columns = props.columns;
    }
    if (props.hideColumns) {
        columns = columns.filter(val => !props.hideColumns.includes(val));
    }
    columns.push('Actions');
    return columns;
});

const rows = computed(() => {
    return props.data.data.map(item =>
        Object.fromEntries(
            Object.entries(item).filter(([key]) => headers.value.includes(key))
        )
    );
});

const handleDelete = (id) => {
    if (props.deleteFunc) {
        props.deleteFunc(id);
    } else {
        if (confirm('Are you sure you want to delete the entry?')) {
            const currentRoute = route().current().split('.')[0];
            router.visit(route(currentRoute + '.destroy', { id }), {
                method: "delete"
            });
        }
    }
};

const isUrl = (str) => {
    try {
        new URL(str);
        return true;
    } catch (_) {
        return false;
    }
}
</script>

<template>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th v-for="header in headers" :key="header" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ header }}
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="item in rows">
                <td v-for="attr in item" class="px-6 py-4 whitespace-nowrap">
                    <img v-if="isUrl(attr)" :src="attr" />
                    <span v-else>{{ attr }}</span>
                </td>
                <td>
                    <div class="flex">
                        <slot name="actions">
                            <slot name="editAction" :item="item">
                                <EditIcon :href="route('users.edit', {user: item.id})" />
                            </slot>
                            <slot name="deleteAction">
                                <DeleteIcon @click="handleDelete(item.id)"/>
                            </slot>
                            <slot name="add-action" :item="item"></slot>
                        </slot>

                    </div>

                </td>
            </tr>
        </tbody>
    </table>
    <Pagination :pagination="pagination"/>

</template>

<style scoped>

</style>

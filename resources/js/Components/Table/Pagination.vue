<script setup>
import {ChevronLeftIcon, ChevronRightIcon} from "@heroicons/vue/20/solid/index.js";
import {Link, router} from "@inertiajs/vue3";
import {computed} from "vue";
import {route, useRoute} from "ziggy-js";

const props = defineProps({
    pagination: Object
});

const currentRoute = route().current().split('.')[0];

const pages = computed(() => {
    const pages = [];
    for (let i = 1; i <= props.pagination.last_page; i++) {
        pages.push({
            label: i,
            url: route(currentRoute + '.index', {page: i })
        });
    }
    return pages;
});
const prevPage = computed(() => {
    const page = props.pagination.current_page !== 1 ? props.pagination.current_page - 1 : null;
    return !page ? '#' :route(currentRoute + '.index', {page: page });
});
const nextPage = computed(() => {
    const page = props.pagination.current_page < props.pagination.last_page ? props.pagination.current_page + 1 : null;
    return !page ? '#' :route(currentRoute + '.index', {page: page });
})

</script>

<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
<!--        <div class="flex flex-1 justify-between sm:hidden">-->
<!--            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>-->
<!--            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>-->
<!--        </div>-->
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    {{ ' ' }}
                    <span class="font-medium">{{ pagination.from }}</span>
                    {{ ' ' }}
                    to
                    {{ ' ' }}
                    <span class="font-medium">{{ pagination.to }}</span>
                    {{ ' ' }}
                    of
                    {{ ' ' }}
                    <span class="font-medium">{{ pagination.total }}</span>
                    {{ ' ' }}
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a :href="prevPage" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </a>
                    <Link
                        v-if="pages"
                        v-for="(link, k) in pages"
                        :href="link.url ? link.url : '#'"
                        :key="k"
                        v-html="link.label"
                        class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex"
                    />
                    <a :href="nextPage" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </a>
                </nav>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>

<script setup>
import {Link} from "@inertiajs/vue3";

const title = 'Menu';
const handleOpenInNewTab = (url, event) => {
    event.preventDefault();
    window.open(url, '_blank', 'noopener,noreferrer')
}
</script>

<template>
    <div class="w-64 shadow-md h-screen fixed bg-black text-white">
        <div class="p-4 text-lg font-bold ">
            {{ title }}
        </div>

        <ul class="space-y-2">
            <Link :href="route('dashboard')" class="block px-4 py-2 hover:bg-gray-700">Dashboard</Link>
            <Link :href="route('admin.home')" class="block px-4 py-2 hover:bg-gray-700"> Admin Home</Link>
            <Link :href="route('users.index')" class="block px-4 py-2 hover:bg-gray-700">Users</Link>
            <Link href="#" class="block px-4 py-2 hover:bg-gray-700"
                  @click="(event) => handleOpenInNewTab(route('telescope'), event)"
            >Telescope</Link>
        </ul>
    </div>
</template>

<style scoped>

</style>

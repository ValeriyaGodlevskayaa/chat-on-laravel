<template>
    <div class="flex items-center justify-between p-4 ">
        <Dropdown align="right" width="48" class="ml-auto">
            <template #trigger>
                <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                    <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                </button>

                <span v-else class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        {{ $page.props.auth.user.name }}

                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            </template>

            <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    Manage Account
                </div>

                <DropdownLink :href="route('profile.show')">
                    Profile
                </DropdownLink>

                <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                    API Tokens
                </DropdownLink>

                <div class="border-t border-gray-200" />

                <!-- Authentication -->
                <form @submit.prevent="logout">
                    <DropdownLink as="button">
                        Log Out
                    </DropdownLink>
                </form>
            </template>
        </Dropdown>
    </div>
    <SectionBorder />

</template>

<script>
import {Link} from "@inertiajs/vue3";
import DropdownLink from "@/Components/DropdownLink.vue";
import Dropdown from "@/Components/Dropdown.vue";
import SectionBorder from "@/Components/SectionBorder.vue";

export default {
    name: "AdminLayout",
    components: {
        SectionBorder,
        Dropdown,
        DropdownLink,
        Link
    }
}
</script>

<style scoped>

</style>

<script setup>
import Page from "@/Pages/Admin/Page.vue";
import Chat from "@/Components/Chat.vue";

const props = defineProps({
    sender: Object,
    user: Object,
    chat: Object,
});


</script>

<template>
    <Page page-title="Chat">
        <Chat :sender="props.sender" :user="user" :chat="chat"/>
    </Page>

</template>

<style scoped>

</style>

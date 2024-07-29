<script setup>
    import { reactive } from 'vue'
    import { router } from '@inertiajs/vue3'

    const form = reactive({
        message: null
    });

    const messages = reactive([]);

    function submit() {
        // if (form.message.length) {
             const msg = form.message;
             messages.push(msg);
        // }
        console.log(msg);
    }
</script>

<template>
    <div class="container h-screen flex flex-col max-h-[calc(100vh-300px)]">
        <div class="flex-grow overflow-y-auto ">
            <div v-for="(ms, key) in messages" key="{{ key }}" class="ml-3">
                <p>{{ms}}</p>
            </div>
        </div>
        <form @submit.prevent="submit" class="w-full fixed bottom-0 left-0 bg-white p-4 shadow-md">
            <div class="flex items-center">
                <label class="chat-label w-1/4 text-gray-700 text-sm font-bold" for="message">
                    Message:
                </label>
                <input id="message" class="chat-message w-full bg-gray-200 border rounded py-2 px-3 focus:outline-none focus:bg-white"
                       name="message" type="text" v-model="form.message"/>
                <button class="ml-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Submit
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>

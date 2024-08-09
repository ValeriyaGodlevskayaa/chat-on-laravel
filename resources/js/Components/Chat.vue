<template>
    <div class="container h-screen flex flex-col max-h-[calc(100vh-200px)]">
        <h1 class="text-center font-bold p-5">{{ chat ? chat.name : 'New Chat' }}</h1>
        <div class="flex justify-end" v-if="messageList && messageList.length">
            <button @click="clearChat" class="ml-3 bg-gray-800 hover:bg-black text-white font-bold py-2 px-4 rounded">Clear chat</button>
        </div>

        <div class="flex-grow overflow-y-auto ">
            <div v-for="(obj, key) in messageList" key="{{ key }}" class="ml-3">
                <div class="inline-flex rounded-md items-center justify-center">
                    <span v-if="senderObj.id === obj.sender_id">
                        <img :src="senderObj.profile_photo_url" class="h-8 w-8 rounded-full object-cover m-2"/>
                    </span>
                    <span v-else-if="userObj.profile_photo_url">
                        <img :src="userObj.profile_photo_url" :alt="userObj.name" class="h-8 w-8 rounded-full object-cover m-2"/>
                    </span>
                    <span v-else>
                       <span>{{userObj.name}}</span>
                    </span>
                    <span>{{ obj.content }}</span>

                </div>
            </div>
        </div>
        <form @submit.prevent="submit" class="w-full bottom-0 left-0 bg-white p-4 shadow-md">
            <div class="flex items-center">
                <label class="chat-label w-1/4 text-gray-700 text-sm font-bold" for="message">
                    Message:
                </label>
                <input id="message" class="chat-message w-full bg-gray-200 border rounded py-2 px-3 focus:outline-none focus:bg-white"
                       name="message" type="text" v-model="formMessage.content"/>
                <button class="ml-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Submit
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import {computed, defineComponent, onBeforeUnmount, onMounted, ref, watch} from 'vue';
import {useForm} from '@inertiajs/vue3';
import {route} from "ziggy-js";

export default defineComponent({
    components: {},
    props: {
        sender: Object,
        user: Object,
        chat: Object
    },
    emits: ['update:chat'],
    setup(props,{ emit }) {
        const senderObj = ref(props.sender?.data);
        const userObj = ref(props.user?.data);

        const formMessage = useForm({
            sender_id: '',
            content: '',
            user_id: '',
            chat_id: ''
        });
        const messageList = computed({
            get() {
                return props.chat ? props.chat.chat_messages : [];
            },
            set(val) {
                 const msg = props.chat.chat_messages;
                 msg.push(val)
                 const updatedChat = { ...props.chat, chat_messages: msg };
                 emit("update:chat", updatedChat);
            }
        })
        const initializeForm = () => {
            formMessage.sender_id = senderObj.value?.id ?? 0;
            formMessage.user_id = props.userId ?? 0;
            formMessage.chat_id = props.chat?.id ?? '';
        };
        watch(
            [() => senderObj.value.id, () => props.userId, () => props.chat],
            () => {
                initializeForm();
                formMessage.chat_id = props.chat?.id ?? '';
            },
            { immediate: true }
        );

        let ws;
        const connectWebSocket = () => {
            ws = new WebSocket("ws://localhost:3001/ws");

            ws.onmessage = (event) => {
                const newMessage = JSON.parse(event.data);
                console.log(newMessage);
                messageList.value = newMessage;
            };

            ws.onopen = () => {
                console.log('WebSocket connection established');
            };

            ws.onerror = (error) => {
                console.error('WebSocket error:', error);
            };

            ws.onclose = () => {
                console.log('WebSocket connection closed');
            };
        };

        onMounted(() => {
            connectWebSocket();
        });

        onBeforeUnmount(() => {
            if (ws) {
                ws.close();
            }
        });

        return {
            senderObj,
            formMessage,
            initializeForm,
            ws,
            messageList,
            userObj
        }
    },
    data() {
        return {

        }
    },
    methods: {
        submit() {
            if (this.formMessage.content) {
                this.formMessage.post(route('chat.store'));
                this.formMessage.content = '';
            }
        },
        clearChat() {
            const url = route('chat.clearChat', this.chat?.id);
            fetch(url).then(response => response.json())
                .then((data) => {
                    if (data.success) {
                        this.chat.chat_messages = [];
                        this.$emit('update:chat', this.chat);
                    }
            }).catch(error => console.error(error));
        }
    }

});

</script>

<style scoped>

</style>

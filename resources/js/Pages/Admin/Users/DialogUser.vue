<script setup>

import TextInput from "@/Components/TextInput.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import {watch} from "vue";

const props = defineProps({
    showDialog: {
        type: Boolean,
        default: false
    },
    user: {
        type: Object,
        default: null
    }
});
const formUser = useForm({
    name: '',
    email: '',
    password: '',
});

const emit = defineEmits([
    'update:show-dialog',
    'update:user'
]);
const toggleDialog = () => {
    emit('update:show-dialog', !props.showDialog);
    emit('update:user', null);
};

const initializeForm = (user) => {
    if (user) {
        formUser.name = user.name;
        formUser.email = user.email;
    } else {
        formUser.reset();
    }
};
watch(() => props.user, (user) => {
    initializeForm(user);
}, { immediate: true });

const submit = () => {
    const options = {
        preserveScroll: true,
        onSuccess: () => {
            toggleDialog();
            formUser.reset();
        }
    };
    if (props.user) {
        formUser.put(`users/${props.user.id}`, options);
    } else {
        formUser.post('users', options);
    }
};

</script>

<template>
    <DialogModal :show="showDialog" @close="toggleDialog">
        <template #title>{{ user ? 'Edit User' : 'Create User' }}</template>
        <template #content>
            <div class="bg-gray-200 bg-opacity-25 gap-6 lg:gap-8 p-6 lg:p-8">
                <div>
                    <div class="items-center w-full">
                        <form>
                            <div class="flex items-center justify-between ">
                                <InputLabel for="name" value="Name"/>
                                <TextInput
                                    id="name"
                                    v-model="formUser.name"
                                    type="text"
                                    class="mt-1 block w-10/12"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                            </div>
                            <InputError class="mt-2" :message="formUser.errors.name" />
                            <div class="mt-4 flex items-center justify-between w-full">
                                <InputLabel for="email" value="Email"/>
                                <TextInput
                                    id="email"
                                    v-model="formUser.email"
                                    type="email"
                                    class="mt-1 block w-10/12"
                                    required
                                    autocomplete="email"
                                />
                            </div>
                            <InputError class="mt-2" :message="formUser.errors.email" />
                            <div class="mt-4 flex items-center justify-between w-full">
                                <InputLabel for="password" value="Password" />
                                <TextInput
                                    id="password"
                                    v-model="formUser.password"
                                    type="password"
                                    class="mt-1 block w-10/12"
                                    required
                                    autocomplete="new-password"
                                />
                            </div>
                            <InputError class="mt-2" :message="formUser.errors.password" />
                        </form>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <secondary-button @click="toggleDialog" class="mr-5">Close</secondary-button>
            <primary-button @click="submit">Save</primary-button>
        </template>
    </DialogModal>
</template>

<style scoped>

</style>

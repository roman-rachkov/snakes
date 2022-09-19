<template>

    <form @submit.prevent="sendMessage">
        <TextInput type="text" name="message" v-model="form.message"/>
        <button type="submit">{{ __('Send') }}</button>
    </form>
</template>

<script setup>
import TextInput from './TextInput.vue'
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import {onMounted} from "vue";
// import {__} from "@/translator";

const page = usePage();

const form = useForm({
    message: ''
});

const userJoinForm = useForm({
    user: {}
})

onMounted(() => {
    window.Echo.join('global.chat')
        .joining((user) => {
            {
                userJoined(user);
            }
        })
        .listen('ChatMessageRecived', function (e) {
            console.log(e);
        });
})

const sendMessage = function () {
    form.post(route('chat'), {
        onFinish: () => form.reset('message')
    })
}

const userJoined = function (user) {
    console.log(user);
    userJoinForm.user = user;
    userJoinForm.post(route('chat.join'), {
        onFinish: () => form.reset('user')
    })
}
</script>

<style scoped>

</style>

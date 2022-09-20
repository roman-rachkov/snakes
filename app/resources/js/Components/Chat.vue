<template>
    <div id="chat" class="flex flex-col min-h-2/6 mt-auto mb-2">
        <div id="messages" class="grow-[5]">
            <ChatMessage v-for="message in chat.messages" :message="message"/>
        </div>
        <form @submit.prevent="sendMessage" class="flex grow" >
            <TextInput type="text" name="message" v-model="form.message" class="grow-[5]"/>

            <div class="grow pl-2">
                <button type="submit" class="border-solid border border-slate-400 w-full h-full rounded hover:bg-slate-200">{{ __('Send') }}</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import TextInput from './TextInput.vue'
import {useForm} from "@inertiajs/inertia-vue3";
import {onMounted} from "vue";
import ChatMessage from "@/Components/ChatMessage.vue";

import {useChat} from "@/Store/chat";

const props = defineProps({
    page: Object
})

const form = useForm({
    message: ''
});

onMounted(() => {
    window.Echo.join('global.chat')
        .joining((user) => {
            {
                chat.addMessage({
                    userName: 'System',
                    message: 'User ' + user.name + ' join to game',
                    time: new Date().toISOString()
                })
            }
        })
        .listen('ChatMessageReceived', function (event) {
            chat.addMessage({
                userName: event.message.author.name,
                message: event.message.message,
                time: event.message.time
            })
        });
})

const chat = useChat();

const sendMessage = function () {
    form.post(route('chat'), {
        onSuccess: () => {
            chat.addMessage({
                userName: props.page.props.auth.user.name,
                message: form.message,
                time: new Date().toISOString()
            })
            form.reset();
        },
        headers: {
            'X-Socket-ID': Echo.socketId(),
        }
    })
}

</script>

<style scoped>

</style>

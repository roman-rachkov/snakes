<template>
    <div id="chat" class="flex flex-col mt-auto mb-2 max-h-[200px]">
        <div id="messages" class="mb-2 border-y pt-2 overflow-y-scroll max-h-[250px]">
            <ChatMessage v-for="message in chat.messages" :message="message"/>
        </div>
        <form @submit.prevent="sendMessage" class="flex" >
            <TextInput type="text" name="message" v-model="form.message" class="grow-[6]"/>

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

const chat = useChat();

onMounted(() => {
    window.Echo.join('global.chat')
        .joining((user) => {
            {
                addMessage({
                    userName: 'System',
                    message: 'User ' + user.name + ' join to game',
                    time: new Date().toISOString()
                })
            }
        })
        .listen('ChatMessageReceived', function (event) {
            addMessage({
                userName: event.message.author.name,
                message: event.message.message,
                time: event.message.time
            })
        });
})

const sendMessage = () => {
    form.post(route('chat'), {
        onSuccess: () => {
            addMessage({
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

const addMessage = (message) => {
    chat.addMessage(message);
    const chatMessages = document.getElementById('messages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

</script>

<style scoped>

</style>

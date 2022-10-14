<template>
    <div id="chat" class="flex flex-col mt-auto my-2 h-full max-h-[280px] bg-white">
        <div id="messages" class="mb-2 border-y py-2 overflow-y-scroll h-[200px] mt-auto custom-scrollbar">
            <ChatMessage v-for="message in chat.messages" :message="message"/>
        </div>
        <form @submit.prevent="sendMessage" class="flex mt-auto">
            <TextInput ref="input" type="text" name="message" v-model="form.message" class="grow-[6]"/>

            <div class="grow pl-2">
                <button type="submit"
                        class="border-solid border border-slate-400 w-full h-full rounded hover:bg-slate-200">{{
                        __('Send')
                    }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import TextInput from './TextInput.vue'
import {useForm} from "@inertiajs/inertia-vue3";
import {onMounted, watch, ref, nextTick} from "vue";
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
            chat.addMessage({
                userName: 'System',
                message: 'User ' + user.name + ' join to game',
                time: new Date().toISOString()
            })
        })
        .listen('ChatMessageReceived',  (event) => {
            chat.addMessage({
                userName: event.message.author.name,
                message: event.message.message,
                time: event.message.time
            })
        });
    // TODO Make private chanel for user
})

const input = ref(null);

const sendMessage = () => {
    if (form.message.trim()) {
        form.post(route('chat'), {
            onSuccess: () => {
                chat.addMessage({
                    userName: props.page.props.auth.user.name,
                    message: form.message.trim(),
                    time: new Date().toISOString()
                })
                form.reset();
                input.value.input.focus()
            },
            headers: {
                'X-Socket-ID': Echo.socketId(),
            }
        })
    }
}

watch(chat.messages, () => {
    const chatMessages = document.getElementById('messages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
}, {
    flush: "post"
})


</script>

<style scoped>

</style>

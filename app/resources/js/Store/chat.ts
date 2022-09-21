import {defineStore} from "pinia";
import {ref} from "vue";

export const useChat = defineStore('chat', {
    state: () => ({
        messages: [] as Message[]
    }),
    actions: {
        addMessage(message) {
            this.messages.push(message);
        }
    }
});

interface Message {
    userName: string,
    message: string,
    time: string
}

import {defineStore} from "pinia";
import {Message} from "./Interfaces/Message";

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

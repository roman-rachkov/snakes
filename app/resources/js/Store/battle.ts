import {defineStore} from "pinia";
import {Room} from "./Interfaces/Room";

export const useBattle = defineStore('battle', {
    state: () => ({
        room: {} as Room
    }),
    actions: {
        update(room) {
            this.room = room;
        }
    }
});

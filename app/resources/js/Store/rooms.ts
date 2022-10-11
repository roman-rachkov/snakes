import {defineStore} from "pinia";
import axios from "axios";

export const useRooms = defineStore('rooms', {
    state: () => ({
        rooms: [] as room[]
    }),
    actions: {
        async init(state) {
            // @ts-ignore
            await axios.get(route('arena.rooms')).then(response => {
                this.rooms = response.data;
            });
        },
    }
});

export interface room {
    id: number,
    playerName: string,
    maxLevel: string,
    minLevel: string,
    bid: number,
    mode: string,
    currentPlayers: number,
    maxPlayers: number,
    status: string
}

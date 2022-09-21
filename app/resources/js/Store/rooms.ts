import {defineStore} from "pinia";
import {Inertia} from "@inertiajs/inertia";

export const useRooms = defineStore('rooms', {
    state: () => ({
        rooms: [] as room[]
    }),
    actions: {
        async init(state) {
            this.rooms = await Inertia.get(route('arena'));
        },
    }
});

interface room {
    id: number,
    playerName: string,
    levels: string,
    bid: number,
    mode: string,
    currentPlayers: number,
    maxPlayers: number,
}

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
        newRoom(room) {
            this.rooms.push(room);
        },
        updateRoom(room) {
            const index = this.rooms.findIndex(item => item.id === room.id);
            if (index > -1) {
                this.rooms[index] = room;
            }
        },
        removeRoom(room) {
            const index = this.rooms.findIndex(item => item.id === room.id);

            if (index > -1) {
                this.rooms.splice(index, 1);
            }

        }
    }
});

export interface room {
    id: number,
    playerName: string,
    max_level: string,
    min_level: string,
    bid: number,
    mode: string,
    current_players: number,
    max_players: number,
    status: string
}

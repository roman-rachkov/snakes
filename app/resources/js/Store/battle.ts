import {defineStore} from "pinia";
import {Room} from "./Interfaces/Room";
import {Action} from "./Interfaces/Action";
import {useChat} from "./chat";
import axios from "axios";

// const chat = useChat();

export const useBattle = defineStore('battle', {
    state: () => ({
        room: {} as Room,
        isTurned: false as Boolean,
        actions: [] as Action[],
        points: 2 as Number,
        target: 0 as Number,
        caster: 0 as Number,
        turnStartTime: Date.now(),
        currentTurnTime: 0
    }),
    actions: {
        update(room) {
            this.room = room;
        },
        initTurn() {
            this.isTurned = false;
            this.turnStartTime = Date.now();
        },
        writeLogsFromLastTurn() {
            const chat = useChat();
            this.room.last_turn.logs.forEach(log => {
                chat.addMessage({
                    userName: 'Battle',
                    message: 'Turn №' + this.room.last_turn.turn + " - " + log.log,
                    time: new Date().toISOString()
                });
            });
        },
        doTurn() {
            if (!this.isTurned) {
                // @ts-ignore
                axios.post(route('battle.turn', {room: this.room.id}), {actions: this.actions})
                    .then(response => this.isTurned = true);
            }
        }

    },
    getters: {
        nextTurnIn(state) {
            return new Date(state.room.next_turn).getTime() - 10000;
        },
        // currentTurnTime(state) {
        //     return Date.now() - state.turnStartTime;
        // },
        maxTurnTime(state) {
            return this.nextTurnIn - state.turnStartTime;
        }
    }

});

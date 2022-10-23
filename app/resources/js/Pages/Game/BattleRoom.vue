<template>

    <Head :title="__('Battle')"/>

    <GameLayout>
        <WaitOtherPlayers v-if="waitingPlayers"/>

        <BattleScreen v-else :room="room"/>

    </GameLayout>
    <!--    <hr>{{ $page.props.room }}-->
</template>

<script setup>

import GameLayout from "@/Layouts/GameLayout.vue";
import {onMounted, ref} from "vue";
import {usePage, Head} from "@inertiajs/inertia-vue3";
import {useChat} from "@/Store/chat";
import WaitOtherPlayers from "@/Components/WaitOtherPlayers.vue";
import BattleScreen from "@/Components/BattleScreen.vue";
import {useBattle} from "@/Store/battle";

const props = defineProps({
    room: Object
});

const chat = useChat();

const page = usePage();

const battle = useBattle();

const waitingPlayers = ref(true);

onMounted(() => {
    battle.update(props.room);

    if (battle.room.status === 'fight') {
        waitingPlayers.value = false;
    }

    window.Echo.join(`battle.${props.room.id}`)
        .listen('UserJoinBattle', (data) => {
            battle.update(data.room);
            chat.addMessage({
                userName: 'Battle',
                message: 'User ' + data.user.name + ' join to battle',
                time: new Date().toISOString()
            })
        })
        .listen('BattleStarted', (data) => {
            battle.update(data.room);
            waitingPlayers.value = false;
        })
        .listen('BattleUpdated', (data) => {
            battle.update(data.room);
        })
    ;
});

</script>

<style scoped>

</style>

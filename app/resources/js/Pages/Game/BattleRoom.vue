<template>

    <Head :title="__('Battle')"/>


    <GameLayout>
        <WaitOtherPlayers v-if="waitingPlayers"/>

        <BattleScreen v-else/>

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

const props = defineProps({
    room: Object
});

const chat = useChat();

const page = usePage();

const waitingPlayers = ref(true);

onMounted(() => {
    if (props.room.status === 'Fight') {
        waitingPlayers.value = false;
    }

    window.Echo.join(`battle.${props.room.id}`)
        .joining((user) => {
            chat.addMessage({
                userName: 'Battle',
                message: 'User ' + user.name + ' join to battle',
                time: new Date().toISOString()
            })
        })
        .listen('BattleStarted', (data) => {
            waitingPlayers.value = false;
        });
});

</script>

<style scoped>

</style>

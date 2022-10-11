<template>

    <GameLayout>
        <h1>WORK!!!</h1>
    </GameLayout>
    <!--    <hr>{{ $page.props.room }}-->
</template>

<script setup>

import GameLayout from "@/Layouts/GameLayout.vue";
import {onMounted} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import {useChat} from "@/Store/chat";

const props = defineProps({
    room: Object
});

const chat = useChat();

const page = usePage();

onMounted(() => {
    window.Echo.join(`battle.${props.room.id}`)
        .joining((user) => {
            chat.addMessage({
                userName: 'Battle',
                message: 'User ' + user.name + ' join to battle',
                time: new Date().toISOString()
            })
        })
});

</script>

<style scoped>

</style>

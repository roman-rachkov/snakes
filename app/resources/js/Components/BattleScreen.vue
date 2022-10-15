<template>
    <div class="w-full h-full rounded  flex items-center justify-between px-5">
        <Snake :snake="battle.room.users[battle.room.users.findIndex(item => item.id === $page.props.auth.user.id)].snake"/>
        <FightControls/>
        <Snake :left="true" :snake="battle.room.users[0].snake"/>
    </div>
</template>

<script setup>
import Snake from "@/Components/Snake.vue"
import FightControls from "@/Components/FightControls.vue"
import {useBattle} from "@/Store/battle"

const battle = useBattle();

</script>

<style scoped>

</style>

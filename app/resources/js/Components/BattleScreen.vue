<template>
    <div class="w-full h-full rounded  flex items-center justify-between px-5">
        <Snake :snake="battle.room.snakes[battle.room.snakes.findIndex(snake => snake.id === $page.props.auth.user.snake.id)]"/>
        <FightControls/>
        <Snake :left="true" :snake="battle.room.snakes[battle.room.snakes.findIndex(snake => snake.id !== $page.props.auth.user.snake.id)]"/>
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

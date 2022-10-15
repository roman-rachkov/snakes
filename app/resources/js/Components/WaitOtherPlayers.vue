<template>

    <div class="w-full h-full rounded border flex items-center justify-center">
        <h3 class="text-2xl">
            {{ __('Waiting other players') }} - {{ battle.room.current_players }}/{{ battle.room.max_players }}
        </h3>
    </div>

</template>

<script setup>
import {useBattle} from "@/Store/battle";

const battle = useBattle()
</script>

<style scoped>

</style>

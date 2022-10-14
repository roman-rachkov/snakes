<template>
    <div class="w-full h-full rounded  flex items-center justify-between px-5">
        <Snake/>
        <FightControls/>
        <Snake left="true"/>
    </div>
</template>

<script setup>
import Snake from "@/Components/Snake.vue"
import FightControls from "@/Components/FightControls.vue"

</script>

<style scoped>

</style>

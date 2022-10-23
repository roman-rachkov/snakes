<template>
    <div class="relative rounded border p-1">
        <img src="../../images/logo.png" class="w-[370px] h-[470px]" :class="{inverse: left}" alt="">
        <div class="bars absolute bottom-0 left-0 w-full p-1">
            <Bar type="hp" :max="props.snake.max_life" :current="props.snake.current_hp" />
            <Bar type="mp" class="mt-2" :max="props.snake.max_mana" :current="props.snake.current_mp" />
        </div>
    </div>
</template>

<script setup>
import Bar from "@/Components/Bar.vue";

const props = defineProps({
    left: Boolean,
    snake: Object
})

</script>

<style scoped>
.inverse {
    transform: rotateY(180deg);
}
</style>

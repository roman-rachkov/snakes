<template>
    <div class="w-full h-[30px] relative flex items-center justify-center rounded empty">
        <div class="h-full current-value absolute bottom-0 left-0 rounded" :class="type"
             :style="{width: currentBarSize+'%'}"></div>
        <span class="z-10" v-if="!props.hideText">{{ props.current }}/{{ props.max }}</span>
    </div>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps({
    type: String,
    max: Number,
    current: Number,
    hideText: Boolean
})

const currentBarSize = computed(() => {
    const size = props.current / (props.max / 100);

    return size > 100 ? 100 : size < 0 ? 0 : size;

});

</script>

<style scoped>

.hp {
    background: rgb(255, 0, 0);
    background: linear-gradient(180deg, rgba(255, 0, 0, 0.9) 0%, rgba(255, 255, 255, 0.2) 35%, rgba(255, 0, 0, 0.9) 75%);
}

.mp {
    background: rgb(0, 91, 255);
    background: linear-gradient(180deg, rgba(0, 91, 255, 0.7) 0%, rgba(255, 255, 255, 0.2) 35%, rgba(0, 91, 255, 0.7) 75%);
}

.time {
    background: rgb(255, 239, 153);
    background: linear-gradient(180deg, rgba(255, 239, 153, 0.7) 0%, rgba(255, 255, 255, 0.2) 35%, rgba(255, 239, 153, 0.7) 75%);
}

.empty {
    background: rgb(226, 232, 240);
    background: linear-gradient(180deg, rgba(226, 232, 240, 0.7) 0%, rgba(255, 255, 255, 0.2) 35%, rgba(226, 232, 240, 0.7) 75%);
}
</style>

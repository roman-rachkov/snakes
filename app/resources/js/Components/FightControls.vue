<template>
    <div class="rounded">
        <div class="base flex justify-around items-center">
            <div class="defend w-[110px] h-[160px]">
                <img src="../../images/battle-snake.png">
            </div>
            <div class="attack w-[110px] h-[160px]">
                <img src="../../images/battle-snake.png">
            </div>
        </div>
        <div class="skills flex mt-2">
            <div class="skill-1 bg-white border w-[110px] h-[110px]"></div>
            <div class="skill-2 bg-white border w-[110px] h-[110px]"></div>
            <div class="skill-3 bg-white border w-[110px] h-[110px]"></div>
            <div class="skill-4 bg-white border w-[110px] h-[110px]"></div>
        </div>
        <div class="attack-btn">
            {{ time }}
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";

const actions = ref([
    {
        type: '',
        target: ''
    },
]);

const time = ref(Date.now())

onMounted(() => {
    setInterval(() => {
        time.value = Date.now()
    }, 1000)
})

</script>

<style scoped>

</style>

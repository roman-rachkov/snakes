<template>
    <div class="w-full h-[30px] relative flex items-center justify-center rounded bg-slate-200">
        <div class="h-full current-value absolute bottom-0 left-0 rounded" :class="type"
             style="width: 33%"></div>
        <span class="">50/150</span>
    </div>
</template>

<script setup>
const props = defineProps({
    type: String
})

</script>

<style scoped>
.hp {
    background: rgb(255, 0, 0);
    background: linear-gradient(180deg, rgba(255, 0, 0, 0.7) 0%, rgba(255, 255, 255, 0.2) 35%, rgba(255, 0, 0, 0.7) 100%);
}

.mp {
    background: rgb(0, 91, 255);
    background: linear-gradient(180deg, rgba(0, 91, 255, 0.7) 0%, rgba(255, 255, 255, 0.2) 35%, rgba(0, 91, 255, 0.7) 100%);
}
</style>

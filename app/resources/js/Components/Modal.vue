<template>
    <div class="modal fixed w-screen h-screen bg-black bg-opacity-75 top-0 bottom-0 right-0 left-0 z-20" @click="close">
        <div ref="backPlate"
            class="absolute w-[50vw] h-[50vh] bg-white -translate-y-[50%] -translate-x-[50%] top-[50%] left-[50%] rounded flex">
            <button @click="emits('closeModal')"
                    class="close absolute right-[25px] top-[25px] before:bg-black after:bg-black"></button>
            <div class="w-[80%] h-[80%] m-auto">
                <slot/>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";

const backPlate = ref(null);
const emits = defineEmits(['closeModal'])

const close = (event) => {
    if(event.target !== backPlate.value){
        emits('closeModal');
    }
}

</script>

<style scoped>

</style>

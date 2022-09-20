<template>
    <p>
        <span class="time">{{ dateTime }}</span>&nbsp;<span class="user-name">{{
            props.message.userName
        }}</span>&nbsp;{{ props.message.message }}
    </p>
</template>

<script setup>

import {computed} from "vue";

const props = defineProps({
    message: Object
})

const dateTime = computed(() => {
    return new Date(Date.parse(props.message.time)).toLocaleString();
});

</script>

<style scoped>
</style>

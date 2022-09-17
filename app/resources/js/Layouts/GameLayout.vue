<template>
    <MainLayout>
        <slot/>
        <Chat/>
    </MainLayout>

</template>

<script>

import MainLayout from "@/Layouts/MainLayout.vue";
import Chat from "@/Components/Chat.vue";

export default {
    name: "GameLayout",
    components: {Chat, MainLayout},
    data() {
        return {}
    }
}
</script>

<style scoped>

</style>

<template>
    <MainLayout>
        <div class="grow-[8] mb-2 h-[520px]">
            <slot />
        </div>
        <Chat class="grow" :page="$page"/>
    </MainLayout>

</template>

<script setup>

import MainLayout from "@/Layouts/MainLayout.vue";
import Chat from "@/Components/Chat.vue";

</script>

<style scoped>

</style>

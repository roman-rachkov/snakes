<template>
    <div class="container mx-auto px-2 flex flex-col min-h-screen">
        <Header @showMenu="showMenu = true"/>
        <hr class="mb-2">
        <Transition name="slide-fade">
            <Menu v-if="showMenu" @closeMenu="showMenu = false"/>
        </Transition>
        <main class="flex flex-col h-full grow">
            <slot/>
        </main>
        <Footer class="mt-auto"/>
    </div>

</template>

<script setup>

import Header from '@/Components/Header.vue'
import Footer from '@/Components/Footer.vue'
import Menu from '@/Components/Menu.vue'
import {ref} from "vue";

const showMenu = ref(false);

</script>

<style scoped>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.4s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(-400px);
    opacity: 0;
}
</style>

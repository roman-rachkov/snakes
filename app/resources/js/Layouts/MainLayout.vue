<template>
    <div class="container mx-auto px-2 h-full flex flex-col min-h-screen justify-between">
        <Header @showMenu="showMenu = true"/>
        <Transition name="slide-fade">
            <Menu v-if="showMenu" @closeMenu="showMenu = false"/>
        </Transition>
        <main class="h-full">
            <slot/>
        </main>
        <Footer />
    </div>

</template>

<script>

import Header from '@/Components/Header.vue'
import Footer from '@/Components/Footer.vue'
import Menu from '@/Components/Menu.vue'

export default {
    name: "MainLayout",
    components: {Header, Footer, Menu},
    data() {
        return {
            showMenu: false
        }
    }
}
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

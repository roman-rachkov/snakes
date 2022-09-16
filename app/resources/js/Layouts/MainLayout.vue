<template>

    <div class="container mx-auto px-2">
        <Header @showMenu="showMenu = true"/>
        <slot/>
        <Footer/>
    </div>

</template>

<script>

import Header from '@/Components/Header.vue'
import Footer from '@/Components/Footer.vue'

export default {
    name: "MainLayout",
    components: {Header, Footer},
    data() {
        return {
            showMenu: false
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <header class="flex justify-between items-center h-20 mt-8">
        <button @click="$emit('showMenu')" class="menu">
            <button class="burger"></button>
        </button>
        <Link class="logo text-5xl">
            <img src="" alt="">
            BiteCobra
        </Link>
        <div class="profile">
            <template v-if="$page.props.auth.user">

            </template>
            <template v-else>

            </template>
        </div>
    </header>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "Header",
    components: {Link}
}
</script>
<style scoped>

.menu{
    @apply block flex justify-center items-center;
    width: 28px;
    height: 40px;
}

.burger {
    @apply block bg-black w-full relative flex justify-center;
    height: 2px;
}

.burger:before {
    content: '';
    @apply block w-4/5 bg-black absolute mx-auto;
    height: 2px;
    bottom: -5px
}

.burger:after {
    content: '';
    @apply block w-2/3 bg-black absolute mx-auto;
    height: 2px;
    bottom: -10px
}

</style>

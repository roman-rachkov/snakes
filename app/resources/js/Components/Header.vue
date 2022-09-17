<template>
    <header class="sticky z-10 flex justify-between items-center h-20 mt-8">
        <button @click="$emit('showMenu')" class="menu relative hover:-translate-y-0.5 hover:drop-shadow-lg">
            <button class="burger"></button>
        </button>
        <Link class="logo flex items-center justify-center">
            <img src="../../images/logo.png" alt="BiteCobra">
            <span>BiteCobra</span>
        </Link>
        <div class="profile flex items-center">
            <template v-if="$page.props.auth.user">
                <div class="balance flex items-center">
                    <span class="block">{{$page.props.auth.user.balance ?? 0}}</span>
                    <img src="../../images/wallet.svg" alt="balance" width="25" height="25" class="ml-3">
                </div>
                <Link class="profile block ml-10 hover:drop-shadow-lg hover:-translate-y-0.5" :href="route('profile')">
                    <span>{{$page.props.auth.user.name}}</span>
                </Link>
                <Link :href="route('logout')" as="button" method="post" class="ml-10 hover:drop-shadow-lg hover:-translate-y-0.5">
                    <Icon icon="ion:exit-outline" width="25px" height="25px"/>
                </Link>
            </template>
            <template v-else>
                <Link :href="route('register')" class="hover:-translate-y-0.5 hover:drop-shadow-lg">
                    <Icon icon="mingcute:user-add-line" width="25px" height="25px"></Icon>
                </Link>
                <Link :href="route('login')" class="ml-10 hover:-translate-y-0.5 hover:drop-shadow-lg">
                    <Icon icon="radix-icons:enter" width="25px" height="25px"></Icon>
                </Link>
            </template>
        </div>
    </header>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import {Icon} from "@iconify/vue";

export default {
    name: "Header",
    components: {Link, Icon}
}
</script>
<style scoped>

.logo {
    font-size: 40px;
    font-family: 'Terasong', serif;
}

.logo span {
    @apply mt-4;
}

.logo img {
    width: 52px;
    height: 52px;
}

.menu {
    @apply block flex justify-center items-center;
    width: 25px;
    height: 25px;
}

.burger {
    @apply block bg-black w-full absolute flex justify-center top-1.5;
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

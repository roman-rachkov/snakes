<template>
    <div class="w-4/12 bg-black h-screen fixed top-0 left-0 z-20">
        <button @click="$emit('closeMenu')" class="close absolute left-3/4 top-14"></button>
        <div class="flex justify-center items-center w-full h-full" v-if="menu">
            <ul>
                <li v-for="(item, idx) in menu" :key="idx" class="mb-5 hover:-translate-y-0.5">
                    <Link :href="route(item.path)" class="text-white text-xl hover:underline">{{ __(item.key) }}</Link>
                </li>

                <template v-if="$page.props.auth.user">
                    <li class="mb-5 hover:-translate-y-0.5">
                        <Link :href="route('game.arena')" class="text-white text-xl hover:underline hover:text-slate-200 ">{{
                                __('Go to game')
                            }}
                        </Link>
                    </li>
                    <li class="mb-5 hover:-translate-y-0.5">
                        <Link :href="route('logout')" as="button" method="post" class="text-white text-xl hover:underline hover:text-slate-200 ">{{
                                __('Log Out')
                            }}
                        </Link>
                    </li>
                </template>
                <template v-else>
                    <li class="mb-5 hover:-translate-y-0.5">
                        <Link :href="route('login')" class="text-white text-xl hover:underline hover:text-slate-200 ">{{ __('Login') }}</Link>
                    </li>
                    <li class="mb-5 hover:-translate-y-0.5">
                        <Link :href="route('register')" class="text-white text-xl hover:underline hover:text-slate-200 ">{{
                                __('Registration')
                            }}
                        </Link>
                    </li>
                </template>

            </ul>
        </div>
    </div>
</template>

<script>

import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {Link},
    name: "Menu",
    data() {
        return {
            menu: [
                {
                    key: 'Main',
                    path: 'main'
                },
            ]
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <GameLayout>
        <div class="min-h-200px grid grid-cols-12 gap-2">
            <div class="collage col-start-1 col-end-6 ">
                <img :src="'https://loremflickr.com/1280/720/snake,cobra?t=2'" alt="" class="object-scale-down">
            </div>
            <div id="roomList" class="col-start-6 ">
                <table class="w-full">
                    <thead>
                    <tr class="flex justify-between items-center">
                        <td class="max-w-[120px]">{{ __('Character') }}</td>
                        <td>{{ __('Player') }}</td>
                        <td>{{ __('Levels') }}</td>
                        <td>{{ __('Bid') }}</td>
                        <td>{{ __('Mode') }}</td>
                        <td>{{ __('Players') }}</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="max-h-[170px] flex justify-between items-center">
                        <td class="max-w-[120px]">
                            <img src="https://loremflickr.com/1280/720/snake,cobra" alt=""
                                 class="max-h-[170px] max-w-[120px] object-scale-down">
                        </td>
                        <td>Игрок</td>
                        <td>1-3</td>
                        <td>100</td>
                        <td>{{ __('Deathmatch') }}</td>
                        <td>1/2</td>
                        <td>
                            <Link >{{__('Accept')}}</Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </GameLayout>
</template>

<script>
import GameLayout from "@/Layouts/GameLayout.vue";
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "Arena",
    components: {GameLayout, Link}
}
</script>

<style scoped>
td {
    @apply flex justify-center items-center w-[120px];
}
</style>

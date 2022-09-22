<template>
    <div class="max-h-[170px] py-3" :class="{'bg-slate-200': props.colored}">
        <!--                            {{room.}}-->
<!--        <div class="max-w-[120px] table-td">-->
<!--            <img src="https://loremflickr.com/1280/720/snake,cobra" alt=""-->
<!--                 class="max-h-[170px] max-w-[120px] object-scale-down">-->
<!--        </div>-->
<!--        <div class="table-td">{{ props.room.playerName }}</div>-->
        <div class="table-td">{{ props.room.minLevel }}-{{props.room.maxLevel}}</div>
        <div class="table-td">{{ props.room.bid }}</div>
        <div class="table-td">{{ __(props.room.mode) }}</div>
        <div class="table-td">{{ props.room.currentPlayers }}/{{ room.maxPlayers }}</div>
        <div class="table-td">
            <Link as="button" class="rounded block w-[90%] h-10 border-2 flex justify-center items-center"
                  :class="{'border-white': props.colored, 'hover:bg-white': props.colored, 'hover:bg-slate-200': !props.colored}">
                <Icon :icon="(props.room.status === 'Open') ? 'akar-icons:double-sword' : 'fluent:lock-closed-24-regular'" class="mr-2"/>
                {{
                    __('Fight')
                }}
            </Link>
        </div>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/inertia-vue3";
import {Icon} from "@iconify/vue";

const props = defineProps({
    room: Object,
    colored: Boolean
})

</script>

<style scoped>

</style>

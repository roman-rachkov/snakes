<template>
    <GameLayout>
        <div class="max-h-[520px] grid grid-cols-12 gap-2">
            <div class="collage col-start-1 col-end-6 h-full max-h-[520px]">
                <img src="../../../images/collage.jpg" alt="" class="object-contain h-full w-full">
            </div>
            <div id="roomList" class="col-start-6 col-end-13">

                <div class="max-h-[520px] flex flex-col">
                    <div class="flex justify-around  pr-2">
                        <!--                        <div class="table-td">{{ __('Character') }}</div>-->
                        <!--                        <div class="table-td">{{ __('Player') }}</div>-->
                        <div class="table-td">{{ __('Levels') }}</div>
                        <div class="table-td">{{ __('Bid') }}</div>
                        <div class="table-td">{{ __('Mode') }}</div>
                        <div class="table-td">{{ __('Players') }}</div>
                        <div class="table-td">
                            <button
                                @click="createRoomModal = true"
                                class="rounded block w-[90%] h-10 border-2 flex justify-center items-center hover:bg-slate-200">
                                <Icon icon="uil:create-dashboard" class="mr-2"/>
                                {{ __('Add') }}
                            </button>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="overflow-y-scroll custom-scrollbar pr-2">
                        <RoomItem v-for="(room, idx) in arena.rooms" :key="room.id" :room="room"
                                  class="flex justify-around" :colored="idx % 2 === 0"/>
                    </div>
                </div>
            </div>
        </div>

        <Modal v-if="createRoomModal" @closeModal="createRoomModal= false">
            <form>
                <div>
                    <InputLabel for="bid" :value="__('Bid')"/>
                    <TextInput id="bid" type="number" min="0" step="10" class="mt-1 w-full"/>
                    <InputError class="mt-2" :message="form.errors.bid"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="players" :value="__('Max players')"/>
                    <TextInput id="players" type="number" min="2" step="1" max="8" class="mt-1 w-full"/>
                    <InputError class="mt-2" :message="form.errors.players"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="mode" :value="__('Battle mode')"/>
                    <SelectInput>
                        <option value="Deathmatch" selected>{{__('Deathmatch')}}</option>
                        <option value="Team">{{__('Team')}}</option>
                    </SelectInput>
                    <InputError class="mt-2" :message="form.errors.mode"/>
                </div>
            </form>
        </Modal>
    </GameLayout>
</template>

<script setup>
import GameLayout from "@/Layouts/GameLayout.vue";
import {useRooms} from "@/Store/rooms";
import {onMounted, ref} from "vue";
import RoomItem from "@/Components/RoomItem.vue";
import {Icon} from "@iconify/vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import {useForm} from "@inertiajs/inertia-vue3";

const arena = useRooms();

const createRoomModal = ref(false);

const form = useForm({
    bid: Number,
    players: Number,
    mode: String,
});

onMounted(() => {
    arena.init();
});


</script>

<style scoped>


</style>

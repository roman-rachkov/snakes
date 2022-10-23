<template>
    <div class="rounded" disabled="true">
        <p class="points text-center mb-2">
            {{ __('Action points') }}: {{ points }}/2
        </p>
        <div class="base flex justify-around items-center">
            <div class="defend w-[110px] h-[160px] relative">
                <img alt="" src="../../images/battle-snake.png">
                <div class="w-full h-1/3 absolute left-0 top-0" data-direction="head" data-type="defend" data-cost="1"
                     @click="setActionToTurn"></div>
                <div class="w-full h-1/3 absolute left-0 top-[33%]" data-direction="body" data-type="defend"
                     data-cost="1"
                     @click="setActionToTurn"></div>
                <div class="w-full h-1/3 absolute left-0 top-[66%]" data-direction="foots" data-type="defend"
                     data-cost="1"
                     @click="setActionToTurn"></div>
            </div>
            <div class="attack w-[110px] h-[160px] relative">
                <img src="../../images/battle-snake.png" alt="">
                <div class="w-full h-1/3 absolute left-0 top-0" data-direction="head" data-type="attack" data-cost="1"
                     @click="setActionToTurn"></div>
                <div class="w-full h-1/3 absolute left-0 top-[33%]" data-direction="body" data-type="attack"
                     data-cost="1"
                     @click="setActionToTurn"></div>
                <div class="w-full h-1/3 absolute left-0 top-[66%]" data-direction="foots" data-type="attack"
                     data-cost="1"
                     @click="setActionToTurn"></div>
            </div>
        </div>
        <div class="skills flex mt-2">
            <div class="skill-1 bg-white border w-[110px] h-[110px]" data-type="cast" data-cost="2"
                 @click="setActionToTurn">1
            </div>
            <div class="skill-2 bg-white border w-[110px] h-[110px]" data-type="cast" data-cost="2"
                 @click="setActionToTurn">2
            </div>
            <div class="skill-3 bg-white border w-[110px] h-[110px]" data-type="cast" data-cost="2"
                 @click="setActionToTurn">3
            </div>
            <div class="skill-4 bg-white border w-[110px] h-[110px]" data-type="cast" data-cost="2"
                 @click="setActionToTurn">4
            </div>
        </div>
        <div class="attack-btn">
            <Bar :hide-text="false" :current="lineProperties.current" :max="lineProperties.max" type="time"/>
        </div>
    </div>
</template>

<script setup>
import {computed, onMounted, ref, watch} from "vue";
import {useBattle} from "@/Store/battle";
import {isEqual} from "lodash";
import {usePage} from "@inertiajs/inertia-vue3";
import axios from "axios";
import Bar from "@/Components/Bar.vue";

const page = usePage();

const points = ref(2);

const battle = useBattle();

const target = ref(battle.room.users[battle.room.users.findIndex(user => user.id !== page.props.value.auth.user.id)].snake.id)
const caster = ref(page.props.value.auth.user.snake.id);

const actions = ref([]);

const time = ref(Date.now());

const isTurned = ref(false);

const turnStartTime = ref(Date.now());
const nextTurnIn = ref(new Date(battle.room.next_turn).getTime() - 3000);

const lineProperties = ref({
    current: 0,
    max: nextTurnIn.value - turnStartTime.value
});

onMounted(() => {
    setInterval(() => {
        lineProperties.value.current = Date.now() - turnStartTime.value;
    }, 10);
    setInterval(() => {
        if (Date.now() >= nextTurnIn.value && !isTurned.value) {
            axios.post(route('battle.turn', {'room': battle.room.id}), {actions: actions.value}, {}).then((response) => {
                console.log(response);
                isTurned.value = true;
            })
        }
    }, 1000);
})

watch(battle.room, () => {
    isTurned.value = false;
    nextTurnIn.value = battle.room.next_turn - 3000;
    turnStartTime.value = Date.now();
    lineProperties.value = {
        current: 0,
        max: nextTurnIn.value - turnStartTime.value
    };
})

const setActionToTurn = (e) => {
    const cost = parseInt(e.target.dataset.cost);
    if (points.value >= cost && !e.target.classList.contains('active')) {
        points.value -= cost;
        e.target.classList.add('active');
        actions.value.push({
            caster,
            target,
            action: e.target.dataset.type,
            direction: e.target.dataset.direction,
        });
        return;
    }
    if (e.target.classList.contains('active')) {
        points.value += cost;
        e.target.classList.remove('active');
        actions.value.splice(actions.value.findIndex(object => isEqual(object, {
            caster,
            target,
            action: e.target.dataset.type,
            direction: e.target.dataset.direction,
        })), 1);
        return;
    }
}

</script>

<style scoped>

.defend .active {
    background: radial-gradient(96.79% 96.79% at 50% 50%, rgba(217, 217, 217, 0) 0%, rgba(97, 255, 0, 0.52) 100%)
}

.defend .active:before {
    content: "";
    display: block;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 2px;
    width: 20px;
    height: 20px;
    background: url("../../images/defense.svg") no-repeat center;
    background-size: contain;
}

.attack .active {
    background: radial-gradient(96.79% 96.79% at 50% 50%, rgba(217, 217, 217, 0) 0%, rgba(255, 61, 0, 0.52) 100%)
}

.attack .active:before {
    content: "";
    display: block;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 2px;
    width: 20px;
    height: 20px;
    background: url("../../images/sword.svg") no-repeat center;
    background-size: contain;
}

.skills .active {
    background: radial-gradient(96.79% 96.79% at 50% 50%, rgba(217, 217, 217, 0) 0%, rgba(97, 255, 0, 0.52) 100%)
}

</style>

<template>

    <form @submit.prevent="sendMessage">
        <TextInput type="text" name="message" v-model="form.message"/>
        <button type="submit">{{ __('Send') }}</button>
    </form>
</template>

<script setup>
import TextInput from './TextInput.vue'
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import {onMounted} from "vue";

const page = usePage();

const form = useForm({
    message: ''
});

onMounted(() => {
    window.Echo.join('global.chat')
        .joining(() => console.log(page.props.auth.user.name))
        .listen('.new-message', function (e) {
        console.log(e);
    });
})

const sendMessage = function () {
    form.post(route('chat'), {
        onFinish: () => form.reset('message')
    })
}
</script>

<style scoped>

</style>

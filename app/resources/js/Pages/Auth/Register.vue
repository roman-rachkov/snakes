<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/inertia-vue3';
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    referal: (String | null),
})

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
    referer: ''
});


const submit = () => {
    if (props.referal) {
        form.referer = props.referal;
    }
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

</script>

<template>
    <MainLayout>
        <Head :title="__('Registration')"/>

        <!--        <Head :title="__('Registration')"/>-->

        <form @submit.prevent="submit" class="w-1/4 mx-auto">
            <div>
                <InputLabel for="name" :value="__('Name')"/>
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                           autocomplete="name"/>
                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div class="mt-4">
                <InputLabel for="email" :value="__('Email')"/>
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                           autocomplete="username"/>
                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" :value="__('Password')"/>
                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                           autocomplete="new-password"/>
                <InputError class="mt-2" :message="form.errors.password"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" :value="__('Confirm Password')"/>
                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                           v-model="form.password_confirmation" required autocomplete="new-password"/>
                <InputError class="mt-2" :message="form.errors.password_confirmation"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{__('Already registered')}}?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{__('Registration')}}
                </PrimaryButton>
            </div>
        </form>
    </MainLayout>
</template>

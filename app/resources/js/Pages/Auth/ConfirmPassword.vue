<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import MainLayout from "@/Layouts/MainLayout.vue";

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    })
};
</script>

<template>
    <MainLayout>
        <Head :title="__('Confirm Password')"/>
        <div class="wrapper w-1/4 mx-auto">

            <div class="mb-4 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="password" value="__('Password')"/>
                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                               autocomplete="current-password" autofocus/>
                    <InputError class="mt-2" :message="form.errors.password"/>
                </div>

                <div class="flex justify-end mt-4">
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ __('Confirm') }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </MainLayout>
</template>

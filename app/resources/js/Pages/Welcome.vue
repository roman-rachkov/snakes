<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import MainLayout from "@/Layouts/MainLayout.vue";
</script>

<template>
    <Head :title="__('Welcome')"/>

    <MainLayout>
        <div class="flex justify-center items-center h-full">
            <img :src="'https://loremflickr.com/1280/720/snake,cobra?t=1'" class="w-1/2 object-contain my-auto"/>
            <div class="info ml-20">
                <h1 class="mb-5 text-8xl ">{{ __('Chose your') }} <span
                    style="font-family: Terasong, Serif">BiteCobra</span></h1>
                <p class="">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam amet architecto consequatur
                    consequuntur cumque dolore dolorem doloremque dolorum eligendi eos est ex fugiat illum incidunt
                    ipsa, ipsam iste libero magni mollitia nihil obcaecati placeat porro quasi qui quia quisquam quos
                    recusandae rem repellat sapiente similique tempore, totam unde voluptate voluptatem voluptatibus.
                    Ducimus facere ipsam, laboriosam natus quam sint vero?
                </p>
            </div>
        </div>
    </MainLayout>

</template>

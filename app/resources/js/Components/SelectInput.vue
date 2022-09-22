<script setup>
import {onMounted, ref} from 'vue';

defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const select = ref(null);

onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
});
defineExpose({select});
</script>

<template>
    <select
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="select">
        <slot/>
    </select>
</template>

<template>

    <Icon v-if="name === 'ru'" icon="twemoji:flag-russia"/>
    <Icon v-else icon="twemoji:flag-england"/>

</template>

<script>
import {Icon} from '@iconify/vue';

export default {
    components: { Icon },

    props: ['name']
}
</script>

<template>
    <div class="ml-4">
        <Link :href="route('language', [selectable_locale])">
            <icon class="w-5 h-5" :name="selectable_locale"/>
        </Link>
    </div>
</template>

<script>
import Icon from '@/Components/IconFlag.vue'
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {
        Icon, Link
    },
    computed: {
        selectable_locale() {
            if (this.$page.props.locale === 'ru') {
                return 'en';
            }
            return 'ru'
        }
    },
}
</script>

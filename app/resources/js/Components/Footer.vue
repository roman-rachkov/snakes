<template>
<div class="fixed-bottom bg-black h-20 flex items-center justify-between px-5">
    <p class="text-white">BitCobra &copy; 2022 <span v-if=" new Date(Date.now()).getFullYear() > 2022 ">- {{ new Date(Date.now()).getFullYear() }}</span> </p>
    <LanguageSelector/>
</div>
</template>

<script>
import LanguageSelector from "@/Components/LanguageSelector.vue";
export default {
    name: "Footer",
    components: { LanguageSelector }

}
</script>

<style scoped>

</style>

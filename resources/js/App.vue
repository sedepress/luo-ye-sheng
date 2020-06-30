<template>
    <div>
        <router-view />
        <tabbar />
    </div>
</template>

<script>
    import Tabbar from './components/Tabbar.vue';

    export default {
        name: "App",
        components: {
            Tabbar
        }
    }
</script>

<style scoped>

</style>

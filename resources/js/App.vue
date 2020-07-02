<template>
    <div>
        <router-view />
        <div style="height: 5rem;"></div>
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

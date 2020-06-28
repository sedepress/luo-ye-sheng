<template>
    <van-tabbar v-model="active">
        <van-tabbar-item icon="home-o">标签</van-tabbar-item>
        <van-tabbar-item icon="search">标签</van-tabbar-item>
        <van-tabbar-item icon="friends-o">标签</van-tabbar-item>
    </van-tabbar>
</template>

<script>
    import Vue from 'vue';
    import { Tabbar, TabbarItem } from 'vant';
    import 'vant/lib/tabbar/style';
    import 'vant/lib/tabbar-item/style';

    Vue.use(Tabbar);
    Vue.use(TabbarItem);

    export default {
        data() {
            return {
                active: 0,
            };
        },
    }
</script>

<style scoped>

</style>

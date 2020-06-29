<template>
    <van-tabbar v-model="active">
        <van-tabbar-item icon="shopping-cart-o" url="/shop">购买装备</van-tabbar-item>
        <van-tabbar-item icon="gem-o">我的装备</van-tabbar-item>
        <van-tabbar-item icon="user-o" url="/user">个人信息</van-tabbar-item>
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
                active: 1,
            };
        },
    }
</script>

<style scoped>

</style>

<template>
    <div>
        <van-tabbar v-model="active" route>
            <van-tabbar-item replace icon="shopping-cart-o" to="/shop">购买装备</van-tabbar-item>
            <van-tabbar-item replace icon="gem-o" to="/user/prop">我的装备</van-tabbar-item>
            <van-tabbar-item replace icon="user-o" to="/user">个人信息</van-tabbar-item>
        </van-tabbar>
    </div>
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

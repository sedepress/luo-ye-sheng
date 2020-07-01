<template>
    <van-cell-group title="用户基本信息">
        <van-cell title="邀请码" is-link value="yqm123456" label="点击复制邀请内容，粘贴给你的朋友" />
        <van-cell title="打怪等级" is-link value="1" label="再需要100经验可升级" />
        <van-cell title="挖矿等级" is-link value="1" label="再需要100经验可升级" />
        <van-cell title="锻造等级" is-link value="1" label="再需要100经验可升级" />
        <van-cell title="疲劳值" is-link value="0" label="点击增加疲劳值" />
        <van-cell title="人力值" is-link value="0" label="每邀请一人，增加1点人力值，等他升到2级再奖励3点人力值，再升到5级再奖励6点人力值" />
        <van-cell title="金币数" is-link value="0" label="金币通过打怪获得，层数越高金币掉落越高" />
    </van-cell-group>
</template>

<script>
    import Vue from 'vue';
    import { Cell, CellGroup } from 'vant';
    import 'vant/lib/cell/style';
    import 'vant/lib/cell-group/style';

    Vue.use(Cell);
    Vue.use(CellGroup);

    export default {
        name: "UserProfile",
        data() {
            return {
                userProfile: [],
            };
        },
        created() {
            this.getUserInfo()
        },
        methods: {
            getUserInfo() {

            },
        }
    }
</script>

<style scoped>

</style>

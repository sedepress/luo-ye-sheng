<template>
    <van-dropdown-menu>
        <van-dropdown-item v-model="value1" :options="option1"></van-dropdown-item>
        <van-dropdown-item v-model="value2" :options="option2"></van-dropdown-item>
        <van-dropdown-item v-model="value3" :options="option3"></van-dropdown-item>
    </van-dropdown-menu>
</template>

<script>
    import Vue from 'vue';
    import { DropdownMenu, DropdownItem } from 'vant';
    import 'vant/lib/dropdown-menu/style';
    import 'vant/lib/dropdown-item/style';

    Vue.use(DropdownMenu);
    Vue.use(DropdownItem);

    export default {
        data() {
            return {
                value1: 0,
                value2: 0,
                value3: 0,
                option1: [
                    { text: '全部装备', value: 0 },
                    { text: '武器', value: 1 },
                    { text: '矿石', value: 2 },
                    { text: '锄头', value: 3 },
                    { text: '锻造炉', value: 4 },
                ],
                option2: [
                    { text: '全部等级', value: 0 },
                    { text: '一级', value: 1 },
                    { text: '二级', value: 2 },
                    { text: '三级', value: 3 },
                    { text: '四级', value: 4 },
                    { text: '五级', value: 5 },
                    { text: '六级', value: 6 },
                    { text: '七级', value: 7 },
                    { text: '八级', value: 8 },
                    { text: '九级', value: 9 },
                    { text: '十级', value: 10 },
                ],
                option3: [
                    { text: '排序', value: 0 },
                    { text: '价格升序', value: 1 },
                    { text: '价格降序', value: 2 },
                ],
            };
        },
    }
</script>

<style scoped>

</style>

<template>
    <div>
        <van-dropdown-menu>
            <van-dropdown-item v-model="type" :options="option1"></van-dropdown-item>
            <van-dropdown-item v-model="value2" :options="option2"></van-dropdown-item>
            <van-dropdown-item v-model="value3" :options="option3"></van-dropdown-item>
        </van-dropdown-menu>
        <van-list
            v-model="loading"
            :error.sync="error"
            error-text="请求失败，点击重新加载"
            :finished="finished"
            finished-text="没有更多了"
            @load="onLoad"
        >
            <van-cell v-for="item in list" title-class="shop-name" value-class="pay" label-class="shop-price" is-link :label="item.shop_desc" :key="item.id" :title="item.name" value="购买" />
        </van-list>
        <tabbar />
    </div>
</template>

<script>
    import Vue from 'vue';
    import { DropdownMenu, DropdownItem, List } from 'vant';
    import 'vant/lib/dropdown-menu/style';
    import 'vant/lib/dropdown-item/style';
    import 'vant/lib/list/style';
    import ShopTabbar from "./ShopTabbar";

    Vue.use(List);
    Vue.use(DropdownMenu);
    Vue.use(DropdownItem);


    export default {
        name: "Shop",
        data() {
            return {
                list: [],
                loading: false,
                error: false,
                finished: false,
                page: 1,
                total: 0,
                type: 0,
                value2: 0,
                value3: 0,
                option1: [
                    { text: '全部装备', value: 0 },
                    { text: '武器', value: 1 },
                    { text: '护甲', value: 2 },
                    { text: '鞋子', value: 3 },
                    { text: '锄头', value: 4 },
                    { text: '锻造炉', value: 5 },
                    { text: '矿石', value: 6 },
                    { text: '药品', value: 7 },
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
            }
        },
        components: {
            ShopTabbar
        },
        methods: {
            onLoad() {
                // 异步更新数据
                // setTimeout 仅做示例，真实场景中一般为 ajax 请求
                axios
                    .get('http://luoyesheng.test/shop/list?page=' + this.page)
                    .then(response => {
                        if (this.page == 1) {
                            this.total = response.data.total
                        }
                        for (let i = 0; i < 10; i++) {
                            this.list.push(response.data.data[i]);
                        }
                        this.page++;

                        if (this.page > this.total / 10) {
                            this.finished = true
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        this.error = true
                    })
                    .finally(() => this.loading = false)
            },
        },
    }
</script>

<style scoped>
    .shop-name {
        color: dodgerblue;
    }

    .shop-price {
        color: red;
    }

    .pay {
        color: dodgerblue;
    }
</style>

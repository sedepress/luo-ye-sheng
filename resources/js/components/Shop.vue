<template>
    <div>
        <van-dropdown-menu>
            <van-dropdown-item v-model="type" :options="typeMap" @change="onChange"></van-dropdown-item>
            <van-dropdown-item v-model="rating" :options="ratingMap" @change="onChange"></van-dropdown-item>
            <van-dropdown-item v-model="order" :options="orderMap" @change="onChange"></van-dropdown-item>
        </van-dropdown-menu>
        <van-list
            v-model="loading"
            :error.sync="error"
            error-text="请求失败，点击重新加载"
            :finished="finished"
            finished-text="没有更多了"
            @load="onLoad"
        >
            <van-cell @click="pay(item)" v-for="item in list" title-class="shop-name" value-class="pay" label-class="shop-price" is-link :label="item.shop_desc" :key="item.id" :title="item.name" value="购买" />
        </van-list>
    </div>
</template>

<script>
    import Vue from 'vue';
    import { DropdownMenu, DropdownItem, List, Dialog, Toast } from 'vant';
    import 'vant/lib/dropdown-menu/style';
    import 'vant/lib/dropdown-item/style';
    import 'vant/lib/list/style';
    import 'vant/lib/dialog/style';
    import 'vant/lib/toast/style';

    Vue.use(List);
    Vue.use(DropdownMenu);
    Vue.use(DropdownItem);
    Vue.use(Dialog);
    Vue.use(Toast);


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
                rating: 0,
                order: '',
                typeMap: [
                    { text: '全部装备', value: 0 },
                    { text: '武器', value: 1 },
                    { text: '护甲', value: 2 },
                    { text: '鞋子', value: 3 },
                    { text: '锄头', value: 4 },
                    { text: '锻造炉', value: 5 },
                    { text: '矿石', value: 6 },
                    { text: '药品', value: 7 },
                ],
                ratingMap: [
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
                orderMap: [
                    { text: '排序', value: '' },
                    { text: '价格升序', value: 'price asc' },
                    { text: '价格降序', value: 'price desc' },
                ],
            }
        },
        methods: {
            onLoad() {
                axios
                    .get('/shop/list', {
                        params: {
                            page: this.page,
                            type: this.type,
                            rating: this.rating,
                            order: this.order,
                            token: this.$root.token,
                        }
                    })
                    .then(response => {
                        if (this.page == 1) {
                            this.total = response.data.total
                        }
                        for (let i = 0; i < response.data.data.length; i++) {
                            this.list.push(response.data.data[i]);
                        }
                        this.page++;

                        if (this.list.length == this.total) {
                            this.finished = true
                        }
                    })
                    .catch(error => {
                        Toast.fail('系统错误，请重新点击商店链接');
                        console.log(error)
                        this.error = true;
                    })
                    .finally(() => this.loading = false)
            },
            onChange() {
                this.list = [];
                this.page = 1;
                this.total = 0;
                // 清空列表数据
                this.finished = false;

                // 重新加载数据
                // 将 loading 设置为 true，表示处于加载状态
                this.loading = true;
                this.onLoad();
            },
            pay(shop) {
                Dialog.confirm({
                    title: shop.name,
                    message: '确定要购买此道具吗？',
                })
                    .then(() => {
                        axios
                            .post('/shop/pay', {
                                token: this.$root.token,
                                shop_id: shop.id,
                            })
                            .then(response => {
                                Toast(response.data.msg);
                            })
                            .catch(error => {
                                Toast.fail('系统错误，请重新点击商店链接');
                                this.error = true
                            })
                            .finally(() => this.loading = false)
                    })
                    .catch(() => {
                        // on cancel
                    });
            }
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

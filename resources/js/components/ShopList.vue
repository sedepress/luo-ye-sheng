<template>
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
</template>

<script>
    import Vue from 'vue';
    import { List } from 'vant';
    import 'vant/lib/list/style';

    Vue.use(List);

    export default {
        name: "List",
        data() {
            return {
                list: [],
                loading: false,
                error: false,
                finished: false,
                page: 1,
                total: 0,
            };
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

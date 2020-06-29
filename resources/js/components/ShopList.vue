<template>
    <van-list
        v-model="loading"
        :error.sync="error"
        error-text="请求失败，点击重新加载"
        :finished="finished"
        finished-text="没有更多了"
        @load="onLoad"
    >
        <van-cell v-for="item in list" title-class="shop-name" value-class="pay" label-class="shop-price" is-link label="价格: 1人力值" :key="item" :title="item" value="购买" />
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
            };
        },
        methods: {
            onLoad() {
                // 异步更新数据
                // setTimeout 仅做示例，真实场景中一般为 ajax 请求
                setTimeout(() => {
                    for (let i = 0; i < 10; i++) {
                        this.list.push(this.list.length + 1 + '锄头');
                    }

                    // 加载状态结束
                    this.loading = false;

                    // 数据全部加载完成
                    if (this.list.length >= 40) {
                        this.finished = true;
                    }
                }, 1000);
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

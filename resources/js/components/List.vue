<template>
    <van-list
        v-model="loading"
        :error.sync="error"
        error-text="请求失败，点击重新加载"
        :finished="finished"
        finished-text="没有更多了"
        @load="onLoad"
    >
<!--        <van-cell v-for="item in list" :key="item" :title="item" />-->
        <div class="item" v-for="item in list" :key="item" :title="item">
            <div class="shop">
                <div class="shop-name">
                    1级锄头
                </div>
                <div class="shop-price">
                    价格: 1人力值
                </div>
            </div>

            <div class="pay">
                <div>
                    购买
                </div>
            </div>
        </div>
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
            };
        },
        methods: {
            onLoad() {
                // 异步更新数据
                // setTimeout 仅做示例，真实场景中一般为 ajax 请求
                setTimeout(() => {
                    for (let i = 0; i < 10; i++) {
                        this.list.push(this.list.length + 1);
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
    .item {
        width: 100%;
        display: flex;
        background-color: white;
        margin-bottom: 5px;
        padding-bottom: 5px;
    }

    .shop {
        display: flex;
        flex-direction: column;
    }

    .shop-name {
        margin-left: 10px;
        margin-top: 6px;
        font-size: 14px;
        color: dodgerblue;
    }

    .shop-price {
        margin-left: 10px;
        margin-top: 10px;
        color: red;
        font-size: 8px;
    }

    .pay {
        display: flex;
        flex: 1 1 0%;
        flex-direction: row-reverse;
        margin-right: 10px;
        align-items: center;
        color: dodgerblue;
    }
</style>

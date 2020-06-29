<template>
    <van-list
        v-model="loading"
        :error.sync="error"
        error-text="请求失败，点击重新加载"
        :finished="finished"
        finished-text="没有更多了"
        @load="onLoad"
    >
        <van-cell v-for="item in list" is-link label="攻击1~5" title-class="equip-name" value-class="equip" label-class="equip-range" value="装备" :key="item" :title="item" />
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
                        this.list.push('武器' + this.list.length + 1);
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
    .equip-name {
        color: dodgerblue;
    }

    .equip-range {
        color: red;
    }

    .equip {
        color: dodgerblue;
    }
</style>

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
                page: 1,
                total: 0,
            };
        },
        methods: {
            onLoad() {
                axios
                    .post('/user/prop_list', {
                        page: this.page,
                        token: this.$root.token,
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
                        console.log(error)
                        this.error = true;
                    })
                    .finally(() => this.loading = false)
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

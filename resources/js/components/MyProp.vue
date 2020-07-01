<template>
    <van-list
        v-model="loading"
        :error.sync="error"
        error-text="请求失败，点击重新加载"
        :finished="finished"
        finished-text="没有更多了"
        @load="onLoad"
    >
        <van-cell @click="equip(item)" v-for="item in list" :is-link="item.type != 6 ? true : false " :label="item.prop_desc" title-class="equip-name" value-class="equip" label-class="equip-range" :value="item.type != 6 ? '装备' : ''" :key="item.id" :title="item.name" />
    </van-list>
</template>

<script>
    import Vue from 'vue';
    import {Dialog, List, Toast} from 'vant';
    import 'vant/lib/list/style';
    import 'vant/lib/toast/style';

    Vue.use(Dialog)
    Vue.use(List);
    Vue.use(Toast)

    export default {
        name: "MyProp",
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
                        Toast.fail('系统错误，请重新点击商店链接');
                        console.log(error)
                        this.error = true;
                    })
                    .finally(() => this.loading = false)
            },
            equip(v) {
                if (v.type != 6) {
                    Dialog.confirm({
                        title: v.name,
                        message: '确定要装备此道具吗？',
                    })
                        .then(() => {
                            axios
                                .post('/user/equip', {
                                    token: this.$root.token,
                                    equip_id: v.id,
                                })
                                .then(response => {
                                    Toast('装备成功');
                                })
                                .catch(error => {
                                    Toast('装备失败');
                                    console.log(error)
                                    this.error = true;
                                })
                                .finally(() => this.loading = false)
                        })
                        .catch(() => {
                            // on cancel
                        });
                }
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

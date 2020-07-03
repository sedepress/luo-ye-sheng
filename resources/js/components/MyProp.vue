<template>
    <van-list
        v-model="loading"
        :error.sync="error"
        error-text="请求失败,点击重新加载"
        :finished="finished"
        finished-text="没有更多了"
        @load="onLoad"
    >
        <van-cell @click="equip(item)" v-for="item in list" :is-link="item.type != 7 ? true : false " :label="item.prop_desc" title-class="equip-name" value-class="equip" label-class="equip-range" :value="displayEquip(item)" :key="item.id" :title="item.name" />
    </van-list>
</template>

<script>
    import Vue from 'vue';
    import {Dialog, List, Toast} from 'vant';
    import 'vant/lib/list/style';
    import 'vant/lib/toast/style';
    import 'vant/lib/dialog/style';

    Vue.use(Dialog);
    Vue.use(List);
    Vue.use(Toast);

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
                equipIds: [],
            };
        },
        computed: {
            displayEquip() {
                return function(val) {
                    if (val.type != 7) {
                        if (Object.values(this.equipIds).indexOf(val.id) !== -1) {
                            return '卸下';
                        } else {
                            return '装备';
                        }
                    } else {
                        return '';
                    }
                }
            }
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
                            this.total = response.data.data.total;
                            this.equipIds = response.data.data.equiped_ids;
                        }
                        for (let i = 0; i < response.data.data.list.length; i++) {
                            this.list.push(response.data.data.list[i]);
                        }
                        this.page++;

                        if (this.list.length == this.total) {
                            this.finished = true;
                        }
                    })
                    .catch(error => {
                        Toast.fail('系统错误,请重新点击商店链接');
                        console.log(error)
                        this.error = true;
                    })
                    .finally(() => this.loading = false)
            },
            equip(v) {
                let m = '装备';
                let r = true;
                if (v.type != 7) {
                    if (Object.values(this.equipIds).indexOf(v.id) !== -1) {
                        m = '卸下';
                        r = false;
                    }
                    Dialog.confirm({
                        title: v.name,
                        message: '确定要' + m + '此道具吗？',
                    })
                        .then(() => {
                            axios
                                .post('/user/equip', {
                                    token: this.$root.token,
                                    equip_id: v.id,
                                    r: r
                                })
                                .then(response => {
                                    this.equipIds = response.data.data.equiped_ids;
                                    Toast(m + '成功');
                                })
                                .catch(error => {
                                    Toast(m + '失败');
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

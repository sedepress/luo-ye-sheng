<template>
    <div>
        <van-cell-group title="用户基本信息">
            <van-cell v-clipboard:copy="invContent" v-clipboard:success="copy" v-clipboard:error="onError" :title="yqm.title" is-link :value="yqm.value" label-class="yqm-click" :label="yqm.desc" />
            <van-cell @click="handleClick(item)" v-for="(item,index) in basic" :key="index" :title="item.title" is-link :value="item.value" :label="item.desc" :label-class="item.is_need_render ? 'desc-color' : ''" />
        </van-cell-group>
        <van-cell-group title="人物属性值">
            <van-cell center v-for="(item,index) in attr" :title="item.title" is-link :key="index" :value="item.value" />
        </van-cell-group>
    </div>
</template>

<script>
    import Vue from 'vue';
    import Clipboard from 'vue-clipboard2';
    import {Cell, CellGroup, Dialog, Toast} from 'vant';
    import 'vant/lib/cell/style';
    import 'vant/lib/cell-group/style';
    import 'vant/lib/toast/style';
    import 'vant/lib/dialog/style';

    Vue.use(Cell);
    Vue.use(CellGroup);
    Vue.use(Toast)
    Vue.use(Clipboard)

    export default {
        name: "UserProfile",
        data() {
            return {
                yqm: [],
                basic: [],
                attr: [],
                invContent: '',
                level:['打怪等级', '挖矿等级', '锻造等级', '疲劳值'],
                price: [1, 2, 3, 4, 5, 6, 7, 8, 9]
            };
        },
        created() {
            this.getUserInfo()
        },
        methods: {
            getUserInfo() {
                axios
                    .post('/user/detail', {
                        token: this.$root.token,
                    })
                    .then(response => {
                        this.yqm = response.data.data.yqm;
                        this.basic = response.data.data.basic;
                        this.attr = response.data.data.attr;
                        this.invContent = "大家关注公众号【落叶生】回复 " + response.data.data.yqm.value + " 绑定邀请人，体验随时随地随机能玩的指令游戏！";
                    })
                    .catch(error => {
                        console.log(error);
                        Toast.fail('系统错误，请重新点击商店链接');
                    })
            },
            handleClick(v) {
                let index = this.level.indexOf(v.title)
                let price = this.price[v.value - 1]
                if (index !== -1 && v.is_need_render && index !== 3) {
                    Dialog.confirm({
                        title: '提升' + this.level[index],
                        message: '升级需要消耗' + price + '点人力值',
                    })
                        .then(() => {
                            axios
                                .post('/user/upgrade', {
                                    token: this.$root.token,
                                    level_type: index + 1,
                                })
                                .then(response => {
                                    Toast(response.data.msg);
                                    if (response.data.code == 0) {
                                        this.getUserInfo();
                                    }
                                })
                                .catch(error => {
                                    console.log(error);
                                    Toast.fail('系统错误，请重新点击商店链接');
                                })
                        })
                        .catch(() => {
                            // on cancel
                        });
                } else if (index == 3) {
                    Dialog.confirm({
                        title: '增加疲劳值',
                        message: '1点人力值加10点疲劳',
                    })
                        .then(() => {
                            axios
                                .post('/user/fatigue', {
                                    token: this.$root.token,
                                })
                                .then(response => {
                                    Toast(response.data.msg);
                                    if (response.data.code == 0) {
                                        this.getUserInfo();
                                    }
                                })
                                .catch(error => {
                                    console.log(error);
                                    Toast.fail('系统错误，请重新点击商店链接');
                                })
                        })
                        .catch(() => {
                            // on cancel
                        });
                }
            },
            copy() {
                Toast('复制成功！');
            },
            onError() {
                Toast('复制失败！');
            }
        }
    }
</script>

<style scoped>
    .desc-color {
        color: red;
    }
</style>

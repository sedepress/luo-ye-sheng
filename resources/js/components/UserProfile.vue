<template>
    <div>
        <van-cell-group title="用户基本信息">
            <van-cell v-for="item in userProfile.basic" :title="item.title" is-link :value="item.value" :label="item.desc" :label-class="item.is_need_render ? 'desc-color' : ''" />
        </van-cell-group>
        <van-cell-group title="人物属性值">
            <van-cell v-for="item in userProfile.attr" :title="item.title" is-link :value="item.value" :label="item.desc" />
        </van-cell-group>
    </div>
</template>

<script>
    import Vue from 'vue';
    import {Cell, CellGroup, Toast} from 'vant';
    import 'vant/lib/cell/style';
    import 'vant/lib/cell-group/style';
    import 'vant/lib/toast/style';

    Vue.use(Cell);
    Vue.use(CellGroup);
    Vue.use(Toast)

    export default {
        name: "UserProfile",
        data() {
            return {
                userProfile: [],
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
                        this.userProfile = response.data.data;
                    })
                    .catch(error => {
                        console.log(error);
                        Toast.fail('系统错误，请重新点击商店链接');
                    })
            },
        }
    }
</script>

<style scoped>
    .desc-color {
        color: red;
    }
</style>

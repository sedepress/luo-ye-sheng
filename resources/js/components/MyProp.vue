<template>
    <div>
        <list />
        <tabbar />
    </div>
</template>

<script>
    import List from "./MyPropList";
    import Tabbar from "./MyPropTabbar";

    export default {
        name: "MyProp",
        components: {
            List,
            Tabbar
        }
    }
</script>

<style scoped>

</style>

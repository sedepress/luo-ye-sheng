<template>
    <div>
        <dropdown-menu />
        <list />
        <tabbar />
    </div>
</template>

<script>
    import DropdownMenu from "./DropdownMenu";
    import Tabbar from "./Tabbar";
    import List from "./List";

    export default {
        name: "Shop",
        components: {
            List,
            DropdownMenu,
            Tabbar
        }
    }
</script>

<style scoped>

</style>

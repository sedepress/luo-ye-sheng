<template>
    <div>
        <user-cell />
        <user-tabbar />
    </div>
</template>

<script>
    import UserCell from "./UserCell";
    import UserTabbar from "./UserTabbar";

    export default {
        name: "UserProfile",
        components: {
            UserCell,
            UserTabbar
        }
    }
</script>

<style scoped>

</style>

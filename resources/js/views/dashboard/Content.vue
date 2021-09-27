<template>
    <router-view />    
</template>

<script>
    export default {
        mounted() {
            console.log('Content wrapper mounted.')
        }
    }
</script>
<style lang="scss" scoped>    
    .layout-boxed .content-wrapper, .layout-boxed .main-header, .layout-boxed .main-footer {
        z-index: 0; 
    }
</style>
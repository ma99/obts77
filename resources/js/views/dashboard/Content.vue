<template>
    <router-view 
        :role="role"
    />    
</template>

<script>
    
    export default {
        props: {
          role: String
        },
        mounted() {
            console.log('Content wrapper mounted.')
        }
    }
</script>
<style lang="scss" scoped>    
    // .layout-boxed .content-wrapper, .layout-boxed .main-header, .layout-boxed .main-footer {
    //     z-index: 0; 
    // }
</style>
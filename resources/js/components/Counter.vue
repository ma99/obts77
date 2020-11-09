<template>
    <div>

       Count: {{ count }}
    </div>     
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        computed: {
            count () {
              return this.$store.state.count
            }
        },
    }
</script>

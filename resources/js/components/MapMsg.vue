<template>
    <div>        
        <h1> MAP MSG </h1>
    </div>
</template>

<script>
    // import Counter from './Counter'
    
    export default {
        props: {
            google: Object
        },
        data() {
            return {
                msg: null,
            }
        },
        mounted() {
            console.log('Map Msg Component mounted.')
            this.msg= this.google
            console.log('map-msg', this.google)
        },
        
        methods: {
            // increaseNumber() {
            //     this.number++
            // }
        }
    }
</script>

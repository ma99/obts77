<template>
    <div>        
        <map-test @load-event="loaderStatus">             
            
            <template v-slot="{ google, map }">
                <map-msg 
                    v-if="loaded" 
                    :google="google"
                />                 
            </template>
           
        </map-test>    
    </div>
</template>

<script>
    // import Counter from './Counter'
    import MapMsg from './MapMsg'
    
    export default {
        components: {
            MapMsg,
        },
        
        data() {
            return {
                msg: 'Hello',
                number: 2,
                loaded: false
            }
        },
        mounted() {
            console.log('Map Test Component mounted.')
            // this.loaded= true
        },
        
        methods: {
            // increaseNumber() {
            //     this.number++
            // }
            loaderStatus(e) {
                console.log('evnt', e)
                this.loaded = e
            }
        }
    }
</script>

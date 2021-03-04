<template>
   <!--  <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                        Vue 3
                        mmbbbbbbbb
                        <counter />
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div>        
        <slot v-bind="self" />    
    </div>
</template>

<script>
    import Counter from './Counter'
    
    export default {
        components: {
            Counter,
        },
        data() {
            return {
                msg: 'Hello',
                number: 2
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        computed: {
            self() { return { ...this } },

            numberSquare() {
              return this.number * this.number;
            }
        },
        methods: {
            increaseNumber() {
                this.number++
            }
        }
    }
</script>

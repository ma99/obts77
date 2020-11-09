<template>
    <div class="container">
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
    </div>
</template>

<script>
    import Counter from './Counter'
    
    export default {
        components: {
            Counter,
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

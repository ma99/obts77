<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        // props: ['user'],
        data() {
            return {
                            
            }
        },
        mounted() {
            // console.log('Component mounted.')
            //console.log('user:', this.user);          
            
            this.eventListenThroughBroadCastChannel();
        },
        methods: {
            eventListenThroughBroadCastChannel() {
                Echo.channel('test-channel')
                    .listen('.event.fired', (e) => {
                        console.log('evnt', e);
                });
                // Echo.private(`channel.${this.user.id}`)
                //     .listen('PrivateEvent', (e) => {
                //         console.log('evnt', e);
                // });
                console.log('ET');
            }
        }
    }
</script>

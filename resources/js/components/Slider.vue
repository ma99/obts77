<template>
    <div class="slide-wrapper">
      <div>
        <img src="/storage/images/bus/slider/1.jpg" class="img-fluid" alt="1">
      </div>
      <div>
        <img src="/storage/images/bus/slider/2.jpg" class="img-fluid" alt="2">
      </div>
      <div>
        <img src="/storage/images/bus/slider/3.jpg" class="img-fluid" alt="3">
      </div>
      <div>
        <img src="/storage/images/bus/slider/4.jpg" class="img-fluid" alt="4">
      </div>      
    </div>
</template>

<script>
    import { tns } from 'tiny-slider/src/tiny-slider';
    export default {        
        data() {
            return {                
                slider: undefined,
            }
        },
        mounted() {
            this.slider = tns({
                container: '.slide-wrapper',
                items: 1,
                slideBy: 'page',
                speed: 200,
                autoplay: true,
                controls: false,
                navPosition: 'bottom'
            });
        },        
        
        methods: {            
        }
    }
</script>
<style lang="scss">
  [data-action] {
    display: none;
  }   
</style>

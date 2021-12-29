<template>
    <div class="slide-wrapper">
      <!-- <div>
        <img src="/storage/images/bus/slider/1.jpg" class="img-fluid" alt="1">
      </div>
      <div>
        <img src="/storage/images/bus/slider/2.jpg" class="img-fluid" alt="2">
      </div>
      <div>
        <img src="/storage/images/bus/slider/3.jpg" class="img-fluid" alt="3">
      </div> -->
      <div v-for="(slide, index) in slides">
        <img :src="url(slide.image.path)" width="640" height="360" class="img-fluid" alt="slide.image.title">
      </div>      
    </div>
</template>

<script>
    import { tns } from 'tiny-slider/src/tiny-slider';
    export default {                
        data() {
            return {                
                slider: undefined,
                slides: [],
                // images:[],
            }
        },
        created() {
            // this.initiateSlider();
        },
        async mounted() {
            await this.getSlides();           
            this.initiateSlider();
        },        
        
        methods: {            
            initiateSlider() {
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
            getSlides() {                
                return axios.get('api/slides/active').then(response =>{
                    this.slides = response.data
                }).catch(error => {
                    console.log(error)
                });
            },
            url(path) {              
              return `/storage/${path}`;
            },
        }
    }
</script>
<style lang="scss">
  [data-action] {
    display: none;
  }   
</style>

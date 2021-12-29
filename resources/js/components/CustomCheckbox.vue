<template>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" :id="customCheck(index)" @change="dispatchSlide(slide)" v-model="selectedSlide.active">
        <label v-if="slide.active == true" class="custom-control-label text-muted font-weight-normal" :for="customCheck(index)">
          <span class="text-danger">Uncheck</span> to Deactivate
        </label>
        <label v-if="slide.active == false" class="custom-control-label text-muted font-weight-normal" :for="customCheck(index)">
          <span class="text-primary">Check</span> to Activate
        </label>
    </div>
</template>

<script>
    export default {
        props: ['lavel', 'index', 'slide'],
        data() {
            return {
                   selectedSlide: {
                    active: '',
                    id: '',
                    image: '',
                    index: ''
                   },         
            }
        },
        mounted() {                      
            this.setSlide(this.slide);            
        },        
        methods: {
            dispatchSlide(slide) {                
                if (slide.active === this.selectedSlide.active) {
                    this.$emit('selected', null);    
                    return;
                }
                this.$emit('selected', this.selectedSlide);
            },
            customCheck(index) {
                return `customCheckSlide_${index}`
            },
            setSlide(slide) {
              this.selectedSlide.active = slide.active;
              this.selectedSlide.id = slide.id;
              this.selectedSlide.image = slide.image;
              this.selectedSlide.index = slide.index;
            }
        }
    }
</script>
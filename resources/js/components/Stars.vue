<template>
    <div class="btn-group mr-2" role="group" aria-label="Stars group"
    >
        <button 
            type="button" class="btn btn-light"
            v-for="star in stars"        
            @click.prevent="setSelectedStar(star)"
            :disabled="disable"
        >
            <i                 
                :class="star.status===true ? 'fas' : 'far'"
                class="fa-star text-warning">                    
            </i>
        </button>        
    </div>        
</template>

<script>
    export default {
        props: {
          disable: {
            type: Boolean,
            default: false
          },
          id: Number, 
          index: Number, 
          type: String,
          value: {
            type: Number,
            default: null
          },          
        },
        data() {
            return {
                stars: [
                    { value: 1, status: false, text: 'Very Poor' },
                    { value: 2, status: false, text: 'Poor' },
                    { value: 3, status: false, text: 'Neutral' },
                    { value: 4, status: false, text: 'Good' },
                    { value: 5, status: false, text: 'Excellent' }
                ],
                selectedStar: '',              
            }
        },
        mounted() {            
            console.log('Stars Component mounted')
            this.setStarsBasedOn(this.value);
        },
        watch: {
            'selectedStar'(value) {
                let index = this.stars.indexOf(value);
                if (this.stars[index].status !== true) {
                    this.stars[index].status = true;
                } 
                if(this.stars[index].status === true) {                    
                    this.checkLeftSideOfTheSelectedStar(index);
                    this.checkRightSideOfTheSelectedStar(index);                    
                }
            },            
        },
        methods: {            
            setSelectedStar(star) {                
                this.selectedStar = star;
                this.$emit('clicked', {
                  star: star, 
                  id: this.id,
                  type: this.type
                });
            },
            setStarsBasedOn(value) {
              if (value === null) return;
              let index = this.stars.findIndex(element => element.value === value);
              this.checkLeftSideOfTheSelectedStar(index);
              this.$emit('impression', {
                impression: this.stars[index].text, 
                trip_id: this.id,
                review_index: this.index
              });
            },

            checkLeftSideOfTheSelectedStar(index) {
              for (let i = 0; i <= index; i++) {
                if (this.stars[i].status !== true) {
                  this.stars[i].status = true
                }
              }      
            },
            checkRightSideOfTheSelectedStar(index) {
              for (let i = index+1; i < this.stars.length; i++) {
                if (this.stars[i].status !== false) {
                  this.stars[i].status = false
                }
              }
            }
        }
    }
</script>
<template>
    <div class="btn-group mr-2" role="group" aria-label="First group">
        <button 
            type="button" class="btn btn-light"
            v-for="star in stars"        
            @click.prevent="setSelectedStar(star)"
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
        props: ['id', 'type'],
        data() {
            return {
                stars: [
                    { value: 1, status: false, text: 'Very Poor' },
                    { value: 2, status: false, text: 'Poor' },
                    { value: 3, status: false, text: 'Neutral' },
                    { value: 4, status: false, text: 'Good' },
                    { value: 5, status: false, text: 'Excellent' }
                ],
                selectedStar: ''
            }
        },
        mounted() {            
            console.log('Stars Component mounted')
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
            }
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

            checkLeftSideOfTheSelectedStar(index) {
              for (let i = 0; i < index; i++) {
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

<template>
  <div class="dropdown">
      <label v-text="inputLabel" />  
      <div class="input-group">
        <span class="input-group-prepend">
          <div class="input-group-text bg-white">
            <i class="fas fa-map-marker-alt"></i>
          </div>
        </span>
          <!-- @input="$emit('update:city', $event.target.value)" -->
        <input 
          type="text" 
          placeholder="Enter City" 
          class="form-control pl-0 border-left-0" 
          :value="city" 
          @input="updateValue"
          @keydown.enter = 'enter'
          @keydown.down = 'down'
          @keydown.up = 'up'
          @keyup.esc = "open = false"
        >        
      </div>  
      <div class="dropdown-menu" style="width:100%"
          v-bind:class="{'show': openSuggestion}"
      >
            <a class="dropdown-item" href="#"
                v-for="(suggestion, index) in matches"
                v-bind:class="{'active': isActive(index)}"
                @click.prevent="suggestionClick(index)"
            >
              {{ suggestion.name }} <small>{{ suggestion.id }}</small>              
            </a>
      </div>
  </div>
    
</template>

<script>
    export default {        
        props: {
          city: {
            type: String,
            // required: true
          },
          suggestions: {
            type: Array,
            required: true
          },
          inputLabel: {
            type: String,
            required: true
          },
        },
        emits: ['update:city'],
        data() {
            return {
              open: false,
              current: 0                              
            }
        },

        created() {
          window.addEventListener("click", this.close);
        },

        beforeUnmount() {
          window.removeEventListener("click", this.close);
        },

        mounted() {
            //console.log('Component mounted.')                        
        },
        computed: {
        // Filtering the suggestion based on the input
            matches () {
              // return this.suggestions.filter((obj) => {
              //   return obj.name.indexOf(this.value) >= 0
              // })
              return this.suggestions.filter( ( suggestion, index ) => {
                const regex = new RegExp( this.city, 'gi' );
                return suggestion.name.match( regex );
                });
            },
            openSuggestion () {
              return this.matches.length !== 0 &&
                    this.open === true
            }
        },
        methods: {
            // closing the drop down box
            close(e) {
              if (!this.$el.contains(e.target)) {
                this.open = false;
              }
            },
            // Triggered the input event to cascade the updates to 
            // parent component
            updateValue (e) {
              let value = e.target.value
              
              if (this.open === false) {
                this.open = true
                this.current = 0
              }
              console.log('val=', value)
              this.$emit('update:city', value)
            },

            // When enter key pressed on the input
            enter () {
              console.log('entr=', this.matches[this.current].name)
              this.$emit('update:city', this.matches[this.current].name)
              this.open = false
            },

            // When up arrow pressed while suggestions are open
            up () {
              if (this.current > 0) {
                this.current--
              }
            },

            // When down arrow pressed while suggestions are open
            down () {
              if (this.current < this.matches.length - 1) {
                this.current++
              }
            },

            // For highlighting element
            isActive (index) {
              return index === this.current
            },

            // When one of the suggestion is clicked
            suggestionClick (index) {
              this.$emit('update:city', this.matches[index].name)
              this.open = false
            }

          }

    }
</script>
<style lang="scss" scoped>
  .input-group-text i {
     color: #a0cc59;
  }
</style>
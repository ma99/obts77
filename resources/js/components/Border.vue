<template>
  <div 
    :style="[border, borderColorStyle]"
    :class="[borderColorClass, { shadow: shadow }]"
  >
    <span v-bind:style="heading" v-show="headingShow">        
        <slot name="heading"></slot>        
    </span>
    <slot></slot>
  </div>
</template>

<script>
    export default {
        props: {
          backgroundColor: {
            default: 'white'
          },
          color: String,          
          
          pattern: {
            default: 'none'
          },           
          shadow: {
            default: false
          },
          width: {
            default: '1px'
          }, 
          
          headingBackground: {
            default: 'lightblue'
          }, 
          
          headingWidth: {
            width: '125px'
          }, 
          
          headingShow: {
            default: true
          },
        },
        data() {
            return {
              colors:[
                'navy-blue',          
                'eastern-blue',          
                'pigment-green',   
                'orange-yellow',
                'orange-red',
              ],
              borderColorClass: '',
              borderColorStyle: {
                borderColor: ''
              },
            }
        },
        mounted() {            
          this.setBorderColor(this.color)
        },
        
        computed: {
            border() {
                return {
                  backgroundColor: this.backgroundColor,
                  borderWidth: `${this.width}px`,
                  borderStyle: this.pattern,
                  //border-color: lightblue,
                  padding: '35px 10px 15px',
                  margin: '25px auto 35px',
                  position: 'relative',
                }
            },
            heading() {
              return {                  
                backgroundColor: this.headingBackground, 
                display: 'block',
                fontWeight: 600,
                letterSpacing: '1px',        
                left: '14px',
                top: '-16px',
                textAlign: 'center',
                position: 'absolute',
                padding: '5px 10px',
                width: `${this.headingWidth}px`,
              }
            },                
        },
        methods: {
          setBorderColor(colorName) {
              const colorClass = this.colors.find(color =>
                colorName == color
              );

              // color class available in predefind colors[] 
              if (typeof colorClass !== 'undefined') {

                this.borderColorClass = `${colorName}`;
                return;
              }              

              this.borderColorStyle.borderColor = `${colorName}`;
            }  
        },
        
    }
</script>
<style lang="scss" scoped>
  $navy-blue: #0477BF;
  $eastern-blue: #0396A6;
  $pigment-green: #04BF55;
  $orange-yellow: #F2B705;
  $orange-red: #F24405;
  
  .navy-blue {    
    border-color: $navy-blue;
  }
  .eastern-blue {    
    border-color: $eastern-blue;
  }
  .pigment-green {    
    border-color: $pigment-green;
  }
  .orange-yellow {    
    border-color: $orange-yellow;
  }
  .orange-red {    
    border-color: $orange-red;
  }  
</style>
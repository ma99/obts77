<template>
  <div 
    :style="[box, borderColorStyle]"
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
          borderRadius: {  //rem
            default: 0
          },
          color: String, //border color    
          margin: {
            type: Object,
            default() {
              return {
                top: '1.875', //30px
                bottom: '2.1875' //35px
              }
            }
          },      
          padding: {
            type: Object,
            default() {
              return {
                top: '1.875', //30px
                bottom: '1.5' //35px
              }
            }
          },      
          
          pattern: {
            default: 'none'
          },           
          shadow: {
            type: Boolean,
            default: false
          },
          width: {
            default: '0.0625'  // border width 1px
          }, 
          
          headingBackground: {
            default: 'lightblue'
          }, 
          
          headingWidth: {
            width: '7.8125' //'125px'
          }, 
          
          headingShow: {
            default: true
          },
          headingBorderRadius: { //rem
            default: 0
          }
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
          if (this.color) {            
            this.setBorderColor(this.color)
          }           
        },
        
        computed: {
            box() {
                return {
                  backgroundColor: this.backgroundColor,
                  borderWidth: `${this.width}rem`,
                  borderStyle: this.pattern,
                  borderRadius: `${this.borderRadius}rem`,
                  //border-color: lightblue,
                  // padding: '2.1875rem 0.625rem 1.250rem',
                  padding: `${this.padding.top}rem 0.625rem ${this.padding.bottom}rem`,
                  // margin: '25px auto 35px',
                  margin: `${this.margin.top}rem auto ${this.margin.bottom}rem`,
                  position: 'relative',
                }
            },
            heading() {
              return {                  
                backgroundColor: this.headingBackground, 
                borderRadius: `${this.headingBorderRadius}rem`,
                display: 'block',
                fontWeight: 600,
                letterSpacing: '0.0625rem',        
                left: '2.1875rem',
                top: '-1rem',
                textAlign: 'center',
                position: 'absolute',
                padding: '0.3125rem 0.625rem',
                width: `${this.headingWidth}rem`,
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
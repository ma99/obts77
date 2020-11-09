<template>
  <!-- <span style="font-size: 1.1rem; color: #81c784;"> -->
  <span :style="headerIconStyle" v-show="visible">
    <span :class="['fa-stack', 'fa-2x', { 'text-shadow': shadow }]">        
      <i :class="['fas', iconOuter, 'fa-stack-2x']"></i>
      <i :class="['fas', iconInner, 'fa-stack-1x fa-inverse']"></i>
    </span>  
    <span :style="headerTextColor">      
      <slot></slot>    
    </span>
  </span>      
</template>

<script>
    export default {
        props: {
          'icon-inner': {
            default: 'fa-dice'
          }, 
          'icon-outer': {
            default: 'fa-circle'
          },
          'icon-size': {
            default: '1.1rem'
          },
          'icon-color': {
            default: `hsla(188, 78%, 41%, 1)`
          },
          'text-color': String,  

          visible: {
            type: Boolean,
            default: true
          },          
          shadow: {
            type: Boolean,
            default: false
          },          
        },
        computed: {
          headerIconStyle() {
            return {
              'font-size': `${this.iconSize}rem`,
              color: this.iconColor,
            }
          },
          headerTextColor() {
            return {
              color: this.textColor,
              'font-size': '1.35rem'            
            }
          }
        }
    }
</script>
<style lang="scss" scoped>  
</style>
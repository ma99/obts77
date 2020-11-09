<template>
    <span 
        :style="highLightBackGround"
        :class="{'box-shadow': shadow}"
    >        
        <slot></slot>        
    </span>
</template>

<script>
    export default {
        props: {
            color: String, 
            value: String, 
            shadow: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {                
              highLightBackGround: {
                background: '',
                borderRadius: '', //this.borderRadiusValue + 'px' //'13px'
                padding: '5px 10px',
                color: '#fff'
              }
            }
        },
        mounted() {
            //console.log('Component mounted.')            
            this.highLightBackGround.background = this.color;
            this.highLightBackGround.borderRadius = this.value + 'px';            
        },
        watch: {
            color() {
                this.highLightBackGround.background = this.color;
            }
        }
    }
</script>